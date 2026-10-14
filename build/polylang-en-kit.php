<?php
/**
 * Follow-up to polylang-en.php: align the English pages with the client's original
 * English copy (design kit) plus later client changes; patchkast = "patch cabinet"; locale en_US.
 * Run via atarim-execute-php (body only, without this opening tag).
 */
// Align the English pages with the client's original English copy (design kit) + later client changes
$map=json_decode(<<<'JSON'
{
"Complete care from network cabinet to workstation": "Complete care from patch cabinet to workspace",
"Network cabinets": "Patch cabinets",
"Network cabinet": "Patch cabinet",
"Fibre optic networks": "Fiber optic networks",
"Fibre optic": "Fiber optic",
"04 Fibre optic networks": "04  Fiber optic networks",
"Wi-Fi access points": "WiFi access points",
"<p>We are a dedicated and skilled installer, specialising in the installation, optimisation and maintenance of structured data networks.</p>": "<p>We are a dedicated and skilled installer specializing in the installation, optimization, and maintenance of structured data networks.</p>",
"<p>What sets us apart is not only our technical expertise but also our personal approach. We think along with you and deliver solutions you can rely on — from fibre optic networks to Wi-Fi access points, from network cabinets to cable trays.</p>": "<p>What sets us apart is not only our technical expertise but also our personal approach. We think along with you and deliver solutions you can rely on — from fiber optic networks to WiFi access points, from patch cabinets to cable trays.</p>",
"<p>vtHullenaar BV was born from a passion for the craft and for reliability. What started as a sole proprietorship has grown into a solid company with a clear mission: providing clients with high-quality, stable and professional network solutions.</p>": "<p>vtHullenaar BV was born from a passion for the craft and reliability. What started as a sole proprietorship has grown into a solid corporation with a clear mission: providing clients with high-quality, stable, and professional network solutions.</p>",
"vtHullenaar services": "vtHullenaar activities",
"COMPLETE CARE FROM NETWORK CABINET TO WORKSTATION!": "COMPLETE CARE FROM PATCH CABINET TO WORKSPACE!",
"Contact us": "Get in touch",
"Everything installed to the applicable ISO/IEC 11801 standard, clearly labelled, tested and handed over fully operational.": "Everything installed to the applicable ISO/IEC 11801 standard, clearly coded, tested, and delivered operational.",
"Choosing us means choosing quality, clarity and service you can count on.": "Choosing us means choosing quality, clarity, and service you can count on.",
"<p>Choosing us means choosing quality, clarity and service you can count on.</p>": "<p>Choosing us means choosing quality, clarity, and service you can count on.</p>",
"<p>We deliver reliable and professional network solutions, from design to handover. Whether it is a completely new network, expanding existing infrastructure or resolving faults — we take care of it.</p>": "<p>We provide reliable and professional network solutions, from design to delivery. Whether it involves a completely new network, expanding existing infrastructure, or resolving faults — we handle it.</p>",
"<p>We work for all kinds of businesses in every sector imaginable and deliver tailor-made solutions with an eye for quality and detail, combining technical precision with a practical approach.</p>": "<p>We work with all types of companies across every imaginable sector and deliver tailored solutions with an eye for quality and detail, combining technical precision with a practical approach.</p>",
"Exactly as it should be!": "Just as it should be!",
"<p>High-quality, future-proof and well-organised network connections are the foundation of a well-functioning business network — and that is our speciality. We install copper or fibre optic cabling according to the standards and only hand over once you are satisfied.</p>": "<p>High-quality, future-proof, and organized network connections are the foundation of a well-functioning business network — and that is our specialty. We install copper or fiber optic cabling to standards and deliver only when you are satisfied.</p>",
"<p>Want to connect two of your locations without cabling? Or do you need stable Wi-Fi coverage in your business premises or on your site? We build wireless networks that are reliable and secure.</p>": "<p>Want to connect two of your locations without cabling? Or need stable WiFi coverage in your business premises or on your site? We realize wireless networks that are reliable and secure.</p>",
"<p>A safe working environment starts with good security. We install professional camera systems that connect to your network and provide optimal surveillance of your business premises.</p>": "<p>A safe work environment starts with good security. We install professional camera systems that connect to your network and ensure optimal monitoring of your business premises.</p>",
"<p>Fast, stable and ready for the future. We install fibre optic connections between your network cabinets or server rooms — including termination and clear labelling — and deliver everything tested and documented, including a test report.</p>": "<p>Fast, stable, and ready for the future. We install fiber optic connections between your patch cabinets or server rooms — including termination and clear coding — and deliver everything tested and documented, including a test report.</p>",
"<p>\"vtHullenaar took care of everything when installing our new data network. From advice to handover — everything perfectly arranged and installed according to the standards.\"</p>": "<p>\"vtHullenaar completely relieved us during the installation of our new data network. From advice to delivery — everything perfectly arranged and installed to standards.\"</p>",
"<p>\"Professional, committed and skilled. They think along with you and deliver quality you can rely on. Exactly what you look for in a partner for your business network.\"</p>": "<p>\"Professional, dedicated, and skilled. They think along with you and deliver quality you can rely on. Exactly what you are looking for in a business network partner.\"</p>",
"— vtHullenaar client": "— Customer vtHullenaar",
"Complete care from <strong>network cabinet to workstation</strong>": "Complete care from <strong>patch cabinet to workspace</strong>",
"Email": "E-mail",
"<p>Complete care from network cabinet to workstation.</p>": "<p>Complete care from patch cabinet to workspace.</p>",
"Terms and conditions": "Terms & conditions",
"<p>vtHullenaar B.V. applies the General Terms and Conditions of Delivery for Installation Companies 2024 (ALIB 2024) of Techniek Nederland to all its work and deliveries. These terms transparently set out the rights and obligations of both client and contractor.</p>": "<p>vtHullenaar B.V. applies the General Delivery Conditions for Installing Companies 2024 (ALIB 2024) by Techniek Nederland to all its work and deliveries. These conditions transparently describe the rights and obligations of both client and contractor.</p>",
"<p>Professional installer of data networks, wireless connections and camera security systems.</p>": "<p>Professional installer of data networks, wireless connections, and camera security systems.</p>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/terms-and-conditions/\">Terms and conditions</a></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/terms-and-conditions/\">Terms &amp; conditions</a></p>"
}
JSON
,true);if(!$map){echo 'map err';return;}
$norm=function($s){return trim(preg_replace('/\s+/u',' ',str_replace("\u{00AD}",'',$s)));};
$used=[];$cnt=0;
$walk=function($a,$pk='')use(&$walk,$map,$norm,&$used,&$cnt){foreach($a as $k=>$v){if(is_array($v)){$a[$k]=$walk($v,$k);continue;}if(!is_string($v)||$v==='')continue;$o=$v;$n=$norm($v);
  if($k==='text'&&$n==='Contact us →')$v='Get in touch →';
  elseif(isset($map[$n])){$v=$map[$n];$used[$n]=1;}
  $v=str_replace(['placeholder="Email *"','aria-label="Email address"'],['placeholder="E-mail *"','aria-label="E-mail address"'],$v);
  $v=preg_replace(['/\bfibre\b/','/\bFibre\b/','/specialis/','/optimis/','/organis/','/labelled/'],['fiber','Fiber','specializ','optimiz','organiz','labeled'],$v);
  if($v!==$o)$cnt++;$a[$k]=$v;}return $a;};
$ids=[];foreach([30,31,32,33,34,35,49,50] as $nl){$en=pll_get_post($nl,'en');if($en)$ids[]=$en;}
foreach($ids as $id){$d=json_decode(get_post_meta($id,'_elementor_data',true),true);$c0=$cnt;$d=$walk($d);
  if($id==pll_get_post(35,'en')){$fx=function($els)use(&$fx){foreach($els as &$e){if(($e['id']??'')==='1cf38f3')$e['settings']['title']='General Terms and Conditions';if(!empty($e['elements']))$e['elements']=$fx($e['elements']);}return $els;};$d=$fx($d);}
  update_post_meta($id,'_elementor_data',wp_slash(wp_json_encode($d)));delete_post_meta($id,'_elementor_css');delete_post_meta($id,'_elementor_element_cache');echo "post $id: ".($cnt-$c0)." texts updated\n";}
wp_update_post(['ID'=>pll_get_post(35,'en'),'post_title'=>'Terms & conditions']);
// English locale: US English, to match the kit's American spelling
$l=PLL()->model->get_language('en');$args=['lang_id'=>$l->term_id,'name'=>'English','slug'=>'en','locale'=>'en_US','rtl'=>0,'term_group'=>1,'flag'=>'us'];
$r=method_exists(PLL()->model,'update_language')?PLL()->model->update_language($args):PLL()->model->languages->update($args);
echo 'locale: '.(is_wp_error($r)?$r->get_error_message():'ok')."\n";
delete_transient('pll_languages_list');if(method_exists(PLL()->model,'clean_languages_cache'))PLL()->model->clean_languages_cache();
if(class_exists('\Elementor\Plugin'))\Elementor\Plugin::$instance->files_manager->clear_cache();
echo 'map entries used: '.count($used).'/'.count($map)."\n";foreach(array_diff(array_keys($map),array_keys($used)) as $u)echo "  unused: ".mb_substr($u,0,80)."\n";
// leftovers check
foreach($ids as $id){$raw=get_post_meta($id,'_elementor_data',true);foreach(['fibre','network cabinet','workstation','Wi-Fi','Contact us','labelled','Email *'] as $w)if(stripos($raw,$w)!==false){preg_match_all('~.{0,60}'.preg_quote($w,'~').'.{0,30}~i',$raw,$mm);echo "post $id still has '$w': ".implode(' || ',array_slice($mm[0],0,3))."\n";}}
echo 'en locale now: '.PLL()->model->get_language('en')->locale."\n";
