require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
$log = [];
$data = json_decode(<<<'VTJSON'
__JSON__
VTJSON
, true);
if (!$data) { return 'json decode failed: ' . json_last_error_msg(); }

// 1. design files in the child theme
$dir = get_stylesheet_directory() . '/assets';
wp_mkdir_p($dir);
file_put_contents($dir . '/vt.css', base64_decode('__CSS__'));
file_put_contents($dir . '/vt.js', base64_decode('__JS__'));
$log[] = 'theme assets written to ' . $dir;

// 2. media
$px = function ($id) { return "https://images.pexels.com/photos/$id/pexels-photo-$id.jpeg?auto=compress&cs=tinysrgb&w=1400"; };
$sources = [
  'hero_poster' => ['https://images.pexels.com/videos/1085656/free-video-1085656.jpg?auto=compress&w=1920', 'Network cables – hero poster'],
  'who1' => [$px(5073493), 'Structured data network / patch panel'], 'who2' => [$px(442150), 'Technician at work'],
  'who3' => [$px(6804590), 'Craftsmanship'], 'what1' => [$px(442150), 'Server room'], 'what2' => [$px(6466143), 'Patch cabinet'],
  'svc_data' => [$px(5073493), 'Data networks'], 'svc_wifi' => [$px(2881224), 'Wireless networks'],
  'svc_cam' => [$px(13156207), 'Camera security'], 'svc_staff' => [$px(6804590), 'Staffing'],
];
foreach ([6466143, 5073493, 2881224, 442150, 6804590, 5966513, 13156207, 5073493] as $i => $pid) { $sources['prj' . ($i + 1)] = [$px($pid), 'Project photo']; }
$media = [];
$byUrl = [];
$find = function ($src) { $q = get_posts(['post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids', 'meta_key' => '_vt_src', 'meta_value' => $src]); return $q ? $q[0] : 0; };
// logo
$aid = $find('logo');
if (!$aid) {
  $up = wp_upload_bits('vthullenaar-logo.png', null, base64_decode('__LOGO__'));
  if (empty($up['error'])) {
    $aid = wp_insert_attachment(['post_mime_type' => 'image/png', 'post_title' => 'vtHullenaar logo', 'post_status' => 'inherit'], $up['file']);
    wp_update_attachment_metadata($aid, wp_generate_attachment_metadata($aid, $up['file']));
    update_post_meta($aid, '_wp_attachment_image_alt', 'vtHullenaar BV');
    update_post_meta($aid, '_vt_src', 'logo');
  } else { $log[] = 'logo upload error: ' . $up['error']; }
}
$media['logo'] = $aid;
foreach ($sources as $key => [$url, $alt]) {
  if (isset($byUrl[$url])) { $media[$key] = $byUrl[$url]; continue; }
  $aid = $find($url);
  if (!$aid) {
    $tmp = download_url($url, 60);
    if (is_wp_error($tmp)) { $log[] = "download $key failed: " . $tmp->get_error_message(); continue; }
    $name = 'vt-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($alt)) . '-' . substr(md5($url), 0, 6) . '.jpg';
    $aid = media_handle_sideload(['name' => $name, 'tmp_name' => $tmp], 0, $alt);
    if (is_wp_error($aid)) { @unlink($tmp); $log[] = "sideload $key failed: " . $aid->get_error_message(); continue; }
    update_post_meta($aid, '_wp_attachment_image_alt', $alt);
    update_post_meta($aid, '_vt_src', $url);
  }
  $media[$key] = $byUrl[$url] = $aid;
}
$log[] = 'media: ' . json_encode($media);

// 3. pages
$pages = ['home' => ['Home', 'home'], 'services' => ['Services', 'services'], 'projects' => ['Projects', 'projects'],
  'about' => ['About us', 'about-us'], 'contact' => ['Contact', 'contact'], 'terms' => ['Terms', 'terms']];
$pid = [];
foreach ($pages as $key => [$title, $slug]) {
  $p = get_page_by_path($slug, OBJECT, 'page');
  $pid[$key] = $p ? $p->ID : wp_insert_post(['post_type' => 'page', 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'publish', 'post_content' => '']);
  if ($p && $p->post_status !== 'publish') { wp_update_post(['ID' => $p->ID, 'post_status' => 'publish']); }
}
$permalinks = get_option('permalink_structure');
if (!$permalinks) { update_option('permalink_structure', '/%postname%/'); }
update_option('show_on_front', 'page');
update_option('page_on_front', $pid['home']);
update_option('blogname', 'vtHullenaar BV');
update_option('blogdescription', 'Reliable network solutions');
global $wp_rewrite; $wp_rewrite->init(); flush_rewrite_rules(false);
$log[] = 'pages: ' . json_encode($pid);

// 4. menus
$mkmenu = function ($name, $slug, $location) use ($pid, &$log) {
  $menu = wp_get_nav_menu_object($slug);
  $mid = $menu ? $menu->term_id : wp_create_nav_menu($name);
  if (is_wp_error($mid)) { $log[] = "menu $name error: " . $mid->get_error_message(); return; }
  wp_update_term($mid, 'nav_menu', ['slug' => $slug]);
  foreach ((array) wp_get_nav_menu_items($mid) as $it) { wp_delete_post($it->ID, true); }
  foreach (['home', 'services', 'projects', 'about', 'contact', 'terms'] as $i => $k) {
    wp_update_nav_menu_item($mid, 0, ['menu-item-object-id' => $pid[$k], 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish', 'menu-item-position' => $i + 1]);
  }
  $loc = get_theme_mod('nav_menu_locations', []); $loc[$location] = $mid; set_theme_mod('nav_menu_locations', $loc);
  $log[] = "menu $name ($slug) id $mid";
};
$mkmenu('Main Menu', 'vt-main-menu', 'vt-primary');
$mkmenu('Footer Pages', 'vt-footer-menu', 'vt-footer');

// 5. token replacement
$resolve = function ($node) use (&$resolve, $media, $pid) {
  if (is_array($node)) {
    if (isset($node['url']) && is_string($node['url']) && strpos($node['url'], 'IMG:') === 0) {
      $k = substr($node['url'], 4); $id = $media[$k] ?? 0;
      $node['id'] = $id; $node['url'] = $id ? wp_get_attachment_url($id) : '';
      $node['alt'] = $id ? get_post_meta($id, '_wp_attachment_image_alt', true) : '';
      return $node;
    }
    foreach ($node as $k => $v) { $node[$k] = $resolve($v); }
    return $node;
  }
  if (is_string($node) && strpos($node, 'PAGE:') !== false) {
    return preg_replace_callback('/PAGE:([a-z]+)/', function ($m) use ($pid) { return $m[1] === 'home' ? home_url('/') : get_permalink($pid[$m[1]]); }, $node);
  }
  return $node;
};
$save = function ($post_id, $elements, $tpl, $type) {
  update_post_meta($post_id, '_elementor_edit_mode', 'builder');
  update_post_meta($post_id, '_elementor_template_type', $type);
  update_post_meta($post_id, '_elementor_version', defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : '4.3.4');
  update_post_meta($post_id, '_wp_page_template', $tpl);
  update_post_meta($post_id, '_elementor_data', wp_slash(wp_json_encode($elements)));
  delete_post_meta($post_id, '_elementor_css');
  delete_post_meta($post_id, '_elementor_element_cache');
};
foreach ($pid as $key => $id) {
  $save($id, $resolve($data[$key]), 'elementor_header_footer', 'wp-page');
  update_post_meta($id, '_elementor_page_settings', ['hide_title' => 'yes']);
}

// 6. UAE header + footer templates
$hf = [];
foreach (['header' => ['Site Header', 'type_header'], 'footer' => ['Site Footer', 'type_footer']] as $key => [$title, $type]) {
  $ex = get_posts(['post_type' => 'elementor-hf', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids', 'meta_key' => 'ehf_template_type', 'meta_value' => $type]);
  $id = $ex ? $ex[0] : wp_insert_post(['post_type' => 'elementor-hf', 'post_title' => $title, 'post_status' => 'publish']);
  update_post_meta($id, 'ehf_template_type', $type);
  update_post_meta($id, 'ehf_target_include_locations', ['rule' => ['basic-global'], 'specific' => []]);
  update_post_meta($id, 'ehf_target_exclude_locations', []);
  update_post_meta($id, 'ehf_target_user_roles', ['all']);
  $save($id, $resolve($data[$key]), 'elementor_canvas', 'wp-post');
  $hf[$key] = $id;
}
$log[] = 'UAE templates: ' . json_encode($hf);

// 7. Elementor kit + options
update_option('elementor_disable_color_schemes', 'yes');
update_option('elementor_disable_typography_schemes', 'yes');
$cpt = (array) get_option('elementor_cpt_support', ['page', 'post']);
update_option('elementor_cpt_support', array_values(array_unique(array_merge($cpt, ['page', 'post']))));
$kit = (int) get_option('elementor_active_kit');
if (!$kit && class_exists('\Elementor\Plugin') && isset(\Elementor\Plugin::$instance->kits_manager)) {
  $km = \Elementor\Plugin::$instance->kits_manager;
  if (method_exists($km, 'create_default')) { $kit = (int) $km->create_default(); update_option('elementor_active_kit', $kit); }
}
if ($kit) {
  $ks = (array) get_post_meta($kit, '_elementor_page_settings', true);
  $t = function ($id, $title, $w, $size = null) { $a = ['_id' => $id, 'title' => $title, 'typography_typography' => 'custom', 'typography_font_family' => 'Archivo', 'typography_font_weight' => $w]; if ($size) { $a['typography_font_size'] = ['unit' => 'px', 'size' => $size, 'sizes' => []]; } return $a; };
  $ks['system_colors'] = [
    ['_id' => 'primary', 'title' => 'Navy', 'color' => '#0B1A3A'], ['_id' => 'secondary', 'title' => 'Blue', 'color' => '#1F7FC4'],
    ['_id' => 'text', 'title' => 'Text', 'color' => '#4A5A70'], ['_id' => 'accent', 'title' => 'Sky', 'color' => '#3FA9F5']];
  $ks['custom_colors'] = [
    ['_id' => 'vtink', 'title' => 'Ink', 'color' => '#050B18'], ['_id' => 'vtlight', 'title' => 'Light', 'color' => '#F4F7FB'],
    ['_id' => 'vtline', 'title' => 'Line', 'color' => '#E1E7EF'], ['_id' => 'vtmuted', 'title' => 'Muted on dark', 'color' => '#AFC0D4']];
  $ks['system_typography'] = [$t('primary', 'Headings', '600'), $t('secondary', 'Secondary', '500'), $t('text', 'Body', '400', 16), $t('accent', 'Buttons', '600', 15)];
  $ks['body_typography_typography'] = 'custom';
  $ks['body_typography_font_family'] = 'Archivo';
  $ks['body_color'] = '#4A5A70';
  $ks['container_width'] = ['unit' => 'px', 'size' => 1280, 'sizes' => []];
  $ks['site_name'] = 'vtHullenaar BV';
  update_post_meta($kit, '_elementor_page_settings', $ks);
  delete_post_meta($kit, '_elementor_css');
  $log[] = "kit $kit updated";
} else { $log[] = 'no Elementor kit found'; }

// 8. clear Elementor CSS cache
if (class_exists('\Elementor\Plugin')) { \Elementor\Plugin::$instance->files_manager->clear_cache(); }

// 9. validate every setting key against the registered Elementor controls
$unknown = [];
if (class_exists('\Elementor\Plugin')) {
  $el = \Elementor\Plugin::$instance;
  $ctl = [];
  $controlsFor = function ($node) use ($el, &$ctl) {
    $k = $node['elType'] === 'widget' ? $node['widgetType'] : $node['elType'];
    if (!isset($ctl[$k])) {
      $obj = $node['elType'] === 'widget' ? $el->widgets_manager->get_widget_types($k) : $el->elements_manager->get_element_types($k);
      $ctl[$k] = $obj ? array_keys($obj->get_controls()) : null;
    }
    return $ctl[$k];
  };
  $walk = function ($nodes) use (&$walk, $controlsFor, &$unknown) {
    foreach ($nodes as $n) {
      $keys = $controlsFor($n);
      $k = $n['elType'] === 'widget' ? $n['widgetType'] : $n['elType'];
      if ($keys === null) { $unknown[$k]['__missing_type__'] = 1; }
      else { foreach (array_keys($n['settings']) as $s) { if (!in_array($s, $keys, true)) { $unknown[$k][$s] = 1; } } }
      if (!empty($n['elements'])) { $walk($n['elements']); }
    }
  };
  foreach ($data as $els) { $walk($els); }
  foreach ($unknown as $k => $v) { $unknown[$k] = array_keys($v); }
}
$log[] = 'unknown setting keys: ' . json_encode($unknown);
$log[] = 'hfe header active: ' . (function_exists('hfe_header_enabled') ? var_export(hfe_header_enabled(), true) : 'n/a');
return $log;
