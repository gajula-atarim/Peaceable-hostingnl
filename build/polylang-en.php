<?php
/**
 * One-off: create the English (Polylang) copies of the 6 pages + UAE header/footer,
 * translate every text, map internal links to /en/, build the EN menus.
 * Run via atarim-execute-php (body only, without this opening tag). Idempotent per page.
 */
if(!function_exists('pll_save_post_translations')){echo 'no polylang';return;}
$S=untrailingslashit(home_url());
$dict=json_decode(<<<'JSON'
{
"vtHullenaar BV · Betrouwbare netwerkoplossingen": "vtHullenaar BV · Reliable network solutions",
"Complete ontzorging van patchkast tot werkplek": "Complete care from network cabinet to workstation",
"Neem contact op": "Contact us",
"Onze diensten in één oogopslag": "Our services at a glance",
"Datanetwerken": "Data networks",
"Glasvezelnetwerken": "Fibre optic networks",
"Wifi-accesspoints": "Wi-Fi access points",
"Patchkasten": "Network cabinets",
"Kabelgoten": "Cable trays",
"Draadloze netwerken": "Wireless networks",
"Camerabeveiliging": "Camera security",
"Wandgoten": "Wall trunking",
"Kabelmanagement": "Cable management",
"Telefonie": "Telephony",
"Testrapportage": "Test reporting",
"Wie wij zijn": "Who we are",
"Alles wat wij doen draait om <strong>verbinding</strong> — letterlijk en figuurlijk.": "Everything we do revolves around <strong>connection</strong> — literally and figuratively.",
"<p>Wij zijn een betrokken en vakkundige installateur, gespecialiseerd in de aanleg, optimalisatie en het onderhoud van gestructureerde datanetwerken.</p>": "<p>We are a dedicated and skilled installer, specialising in the installation, optimisation and maintenance of structured data networks.</p>",
"<p>Wat ons onderscheidt, is niet alleen onze technische expertise maar ook onze persoonlijke aanpak. Wij denken met u mee en leveren oplossingen waar u op kunt bouwen — van glasvezelnetwerken tot wifi-accesspoints, van patchkasten tot kabelgoten.</p>": "<p>What sets us apart is not only our technical expertise but also our personal approach. We think along with you and deliver solutions you can rely on — from fibre optic networks to Wi-Fi access points, from network cabinets to cable trays.</p>",
"<p>vtHullenaar BV is ontstaan uit passie voor het vak en voor betrouwbaarheid. Wat begon als eenmanszaak, is uitgegroeid tot een solide BV met een duidelijke missie: klanten voorzien van hoogwaardige, stabiele en professionele netwerkoplossingen.</p>": "<p>vtHullenaar BV was born from a passion for the craft and for reliability. What started as a sole proprietorship has grown into a solid company with a clear mission: providing clients with high-quality, stable and professional network solutions.</p>",
"Werkzaamheden vtHullenaar": "vtHullenaar services",
"COMPLETE ONTZORGING VAN PATCHKAST TOT WERKPLEK!": "COMPLETE CARE FROM NETWORK CABINET TO WORKSTATION!",
"Neem contact op →": "Contact us →",
"Wat wij doen": "What we do",
"Betrouwbare en professionele netwerkoplossingen": "Reliable and professional network solutions",
"Alles aangelegd volgens de geldende ISO/IEC 11801-norm, overzichtelijk gecodeerd, getest en operationeel opgeleverd.": "Everything installed to the applicable ISO/IEC 11801 standard, clearly labelled, tested and handed over fully operational.",
"Kiezen voor ons is kiezen voor kwaliteit, duidelijkheid en service waar u op kunt rekenen.": "Choosing us means choosing quality, clarity and service you can count on.",
"<p>Wij leveren betrouwbare en professionele netwerkoplossingen, van ontwerp tot oplevering. Of het nu gaat om een volledig nieuw netwerk, het uitbreiden van bestaande infrastructuur of het verhelpen van storingen — wij regelen het.</p>": "<p>We deliver reliable and professional network solutions, from design to handover. Whether it is a completely new network, expanding existing infrastructure or resolving faults — we take care of it.</p>",
"<p>Wij werken voor allerlei bedrijven in elke denkbare sector en leveren maatwerk met oog voor kwaliteit en detail, waarbij technische precisie samengaat met een praktische aanpak.</p>": "<p>We work for all kinds of businesses in every sector imaginable and deliver tailor-made solutions with an eye for quality and detail, combining technical precision with a practical approach.</p>",
"Precies zoals het hoort!": "Exactly as it should be!",
"Patchkast": "Network cabinet",
"<p>Hoogwaardige, toekomstbestendige en overzichtelijke netwerkverbindingen vormen de basis van een goed functionerend bedrijfsnetwerk — en dat is onze specialiteit. Wij leggen koper- of glasvezelbekabeling aan volgens de normen en leveren pas op als u tevreden bent.</p>": "<p>High-quality, future-proof and well-organised network connections are the foundation of a well-functioning business network — and that is our speciality. We install copper or fibre optic cabling according to the standards and only hand over once you are satisfied.</p>",
"Draadloos netwerk": "Wireless network",
"<p>Wilt u twee van uw locaties zonder bekabeling met elkaar verbinden? Of heeft u stabiele wifi-dekking nodig in uw bedrijfspand of op uw terrein? Wij realiseren draadloze netwerken die betrouwbaar en veilig zijn.</p>": "<p>Want to connect two of your locations without cabling? Or do you need stable Wi-Fi coverage in your business premises or on your site? We build wireless networks that are reliable and secure.</p>",
"<p>Een veilige werkomgeving begint bij goede beveiliging. Wij installeren professionele camerasystemen die aansluiten op uw netwerk en zorgen voor optimaal toezicht op uw bedrijfspand.</p>": "<p>A safe working environment starts with good security. We install professional camera systems that connect to your network and provide optimal surveillance of your business premises.</p>",
"Glasvezel": "Fibre optic",
"<p>Snel, stabiel en klaar voor de toekomst. Wij leggen glasvezelverbindingen aan tussen uw patchkasten of serverruimtes — inclusief afmonteren en duidelijk coderen — en leveren alles getest en gedocumenteerd met o.a. een meetrapport op.</p>": "<p>Fast, stable and ready for the future. We install fibre optic connections between your network cabinets or server rooms — including termination and clear labelling — and deliver everything tested and documented, including a test report.</p>",
"Diensten": "Services",
"Onze diensten <strong>in één oogopslag</strong>": "Our services <strong>at a glance</strong>",
"Projecten": "Projects",
"Onze <strong>projecten</strong>": "Our <strong>projects</strong>",
"<p>projecten in<br>de galerij</p>": "<p>projects in<br>the gallery</p>",
"Bekijk projecten": "View projects",
"Uw project <strong>hier?</strong>": "Your project <strong>here?</strong>",
"Ervaringen": "Testimonials",
"Wat klanten <strong>zeggen</strong>": "What clients <strong>say</strong>",
"<p>\"vtHullenaar heeft ons volledig ontzorgd bij de aanleg van ons nieuwe datanetwerk. Van advies tot oplevering — alles perfect geregeld en volgens de normen aangelegd.\"</p>": "<p>\"vtHullenaar took care of everything when installing our new data network. From advice to handover — everything perfectly arranged and installed according to the standards.\"</p>",
"— Klant": "— Client",
"<p>\"Professioneel, betrokken en vakkundig. Ze denken met je mee en leveren kwaliteit waar je op kunt bouwen. Precies wat je zoekt in een partner voor je bedrijfsnetwerk.\"</p>": "<p>\"Professional, committed and skilled. They think along with you and deliver quality you can rely on. Exactly what you look for in a partner for your business network.\"</p>",
"— Klant van vtHullenaar": "— vtHullenaar client",
"Complete ontzorging van <strong>patchkast tot werkplek</strong>": "Complete care from <strong>network cabinet to workstation</strong>",
"Mail ons": "Email us",
"Telefoon": "Phone",
"E-mail": "Email",
"Adres": "Address",
"<p>Complete ontzorging van patchkast tot werkplek.</p>": "<p>Complete care from network cabinet to workstation.</p>",
"01 Datanetwerken": "01  Data networks",
"02 Draadloze netwerken": "02  Wireless networks",
"03 Camerabeveiliging": "03  Camera security",
"04 Glasvezelnetwerken": "04  Fibre optic networks",
"Bekijk galerij": "View gallery",
"Over ons": "About us",
"<p>Alles wat wij doen draait om verbinding — letterlijk en figuurlijk.</p>": "<p>Everything we do revolves around connection — literally and figuratively.</p>",
"Wij zijn een betrokken en vakkundige <strong>installateur</strong>": "We are a dedicated and skilled <strong>installer</strong>",
"Betrouwbare en professionele <strong>netwerkoplossingen</strong>": "Reliable and professional <strong>network solutions</strong>",
"<p>Kiezen voor ons is kiezen voor kwaliteit, duidelijkheid en service waar u op kunt rekenen.</p>": "<p>Choosing us means choosing quality, clarity and service you can count on.</p>",
"Volg ons": "Follow us",
"Algemene voorwaarden": "Terms and conditions",
"Voorwaarden": "Terms",
"<p>vtHullenaar B.V. hanteert voor al haar werkzaamheden en leveringen de Algemene Leveringsvoorwaarden voor Installerende Bedrijven 2024 (ALIB 2024) van Techniek Nederland. Deze voorwaarden beschrijven op transparante wijze de rechten en plichten van zowel opdrachtgever als opdrachtnemer.</p>": "<p>vtHullenaar B.V. applies the General Terms and Conditions of Delivery for Installation Companies 2024 (ALIB 2024) of Techniek Nederland to all its work and deliveries. These terms transparently set out the rights and obligations of both client and contractor.</p>",
"Download voorwaarden (PDF)": "Download terms (PDF)",
"Site Header": "Site Header (EN)",
"Site Footer": "Site Footer (EN)",
"<a class=\"vt-lang__opt is-active\" href=\"#\" lang=\"nl\" aria-current=\"true\">NL</a><a class=\"vt-lang__opt\" href=\"#\" lang=\"en\">EN</a>": "<a class=\"vt-lang__opt\" href=\"https://peaceable-serval-4608d1.start.hosting.nl/\" lang=\"nl\" hreflang=\"nl\">NL</a><a class=\"vt-lang__opt is-active\" href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/\" lang=\"en\" hreflang=\"en\" aria-current=\"true\">EN</a>",
"<p>Professionele installateur van datanetwerken, draadloze verbindingen en camerabeveiligingssystemen.</p>": "<p>Professional installer of data networks, wireless connections and camera security systems.</p>",
"Pagina's": "Pages",
"vt-main-menu": "vt-main-menu-en",
"vt-footer-menu": "vt-footer-menu-en",
"<p>KVK: 97375926<br>BTW: NL868025343B01</p>": "<p>CoC (KVK): 97375926<br>VAT: NL868025343B01</p>",
"<p>© 2026 vtHullenaar BV Alle rechten voorbehouden</p>": "<p>© 2026 vtHullenaar BV All rights reserved</p>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/algemene-voorwaarden/\">Algemene voorwaarden</a></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/terms-and-conditions/\">Terms and conditions</a></p>",
"<form class=\"vt-form-el\" method=\"post\" action=\"/wp-admin/admin-post.php\"> <input type=\"hidden\" name=\"action\" value=\"vt_contact\"> <div class=\"vt-form-grid\"><input type=\"text\" name=\"vt_name\" required placeholder=\"Naam\" aria-label=\"Naam\"><input type=\"email\" name=\"vt_email\" required placeholder=\"E-mail *\" aria-label=\"E-mailadres\"></div> <textarea name=\"vt_message\" rows=\"6\" placeholder=\"Bericht\" aria-label=\"Bericht\"></textarea> <input type=\"text\" class=\"vt-hp\" name=\"vt_website\" tabindex=\"-1\" autocomplete=\"off\" aria-hidden=\"true\"> <button type=\"submit\" class=\"vt-submit\">Versturen<span>→</span></button> </form>": "<form class=\"vt-form-el\" method=\"post\" action=\"/wp-admin/admin-post.php\">\n<input type=\"hidden\" name=\"action\" value=\"vt_contact\">\n<div class=\"vt-form-grid\"><input type=\"text\" name=\"vt_name\" required placeholder=\"Name\" aria-label=\"Name\"><input type=\"email\" name=\"vt_email\" required placeholder=\"Email *\" aria-label=\"Email address\"></div>\n<textarea name=\"vt_message\" rows=\"6\" placeholder=\"Message\" aria-label=\"Message\"></textarea>\n<input type=\"text\" class=\"vt-hp\" name=\"vt_website\" tabindex=\"-1\" autocomplete=\"off\" aria-hidden=\"true\">\n<button type=\"submit\" class=\"vt-submit\">Send<span>→</span></button>\n</form>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/\">Home</a><span>/</span><span class=\"is-current\">Diensten</span></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/\">Home</a><span>/</span><span class=\"is-current\">Services</span></p>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/\">Home</a><span>/</span><span class=\"is-current\">Projecten</span></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/\">Home</a><span>/</span><span class=\"is-current\">Projects</span></p>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/\">Home</a><span>/</span><span class=\"is-current\">Over ons</span></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/\">Home</a><span>/</span><span class=\"is-current\">About us</span></p>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/\">Home</a><span>/</span><span class=\"is-current\">Contact</span></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/\">Home</a><span>/</span><span class=\"is-current\">Contact</span></p>",
"<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/\">Home</a><span>/</span><span class=\"is-current\">Voorwaarden</span></p>": "<p><a href=\"https://peaceable-serval-4608d1.start.hosting.nl/en/\">Home</a><span>/</span><span class=\"is-current\">Terms</span></p>"
}
JSON
,true);if(!$dict){echo 'dict err';return;}
$norm=function($s){return trim(preg_replace('/\s+/u',' ',str_replace("\u{00AD}",'',$s)));};
$slugmap=['diensten'=>'services','projecten'=>'projects','over-ons'=>'about-us','contact'=>'contact-us','algemene-voorwaarden'=>'terms-and-conditions'];
$hit=[];$miss=[];
$mapurl=function($v)use($S,$slugmap){
  $q=preg_quote($S,'~');
  $v=preg_replace_callback('~'.$q.'/(diensten|projecten|over-ons|contact|algemene-voorwaarden)(?=/|#|"|$)~',function($m)use($S,$slugmap){return $S.'/en/'.$slugmap[$m[1]];},$v);
  $v=preg_replace_callback('~^/(diensten|projecten|over-ons|contact|algemene-voorwaarden)(?=/|#|$)~',function($m)use($slugmap){return '/en/'.$slugmap[$m[1]];},$v);
  if($v===$S||$v===$S.'/')$v=$S.'/en/';
  $v=str_replace(['href="'.$S.'/"',$S.'/#'],['href="'.$S.'/en/"',$S.'/en/#'],$v);
  if(preg_match('~^/#~',$v))$v='/en'.$v;
  return $v;};
$tr=function($a)use(&$tr,$dict,$norm,$mapurl,&$hit,&$miss){foreach($a as $k=>$v){if(is_array($v)){$a[$k]=$tr($v);continue;}if(!is_string($v)||$v==='')continue;$n=$norm($v);if(isset($dict[$n])){$v=$dict[$n];$hit[$n]=1;}elseif(preg_match('/\p{L}{4}/u',$v)&&strpos($v,' ')!==false&&!preg_match('~^(https?:|fa[bsr]? )~',$v)){$miss[$n]=1;}$a[$k]=$mapurl($v);}return $a;};
$plan=[30=>['Home','home-en'],31=>['Services','services'],32=>['Projects','projects'],33=>['About us','about-us'],34=>['Contact','contact-us'],35=>['Terms and conditions','terms-and-conditions'],49=>['Site Header (EN)','site-header-en'],50=>['Site Footer (EN)','site-footer-en']];
// 1) English menus (copies of the Dutch ones, pointing at the English pages)
$menus=[];
foreach(['vt-main-menu','vt-footer-menu'] as $slug){$src=get_term_by('slug',$slug,'nav_menu');if(!$src){echo "menu slug $slug not found\n";continue;}$menus[$slug]=$src;}
// 2) pages + header/footer
$made=[];
foreach($plan as $src=>[$title,$slug]){
  if($ex=pll_get_post($src,'en')){echo "$src already has EN: $ex\n";$made[$src]=$ex;continue;}
  $p=get_post($src);
  $new=wp_insert_post(['post_type'=>$p->post_type,'post_status'=>'publish','post_title'=>$title,'post_name'=>$slug,'post_content'=>'','menu_order'=>$p->menu_order,'post_author'=>$p->post_author,'comment_status'=>'closed','ping_status'=>'closed'],true);
  if(is_wp_error($new)){echo "ERR $src: ".$new->get_error_message()."\n";continue;}
  pll_set_post_language($new,'en');pll_save_post_translations(['nl'=>$src,'en'=>$new]);
  foreach(get_post_meta($src) as $k=>$vals){if(in_array($k,['_elementor_data','_elementor_css','_elementor_element_cache','_edit_lock','_edit_last','_wp_old_slug','_elementor_page_assets'],true))continue;foreach($vals as $v)add_post_meta($new,$k,wp_slash(maybe_unserialize($v)));}
  $d=json_decode(get_post_meta($src,'_elementor_data',true),true);
  update_post_meta($new,'_elementor_data',wp_slash(wp_json_encode($tr($d))));
  $made[$src]=$new;
  echo "$src -> $new ".get_permalink($new)."\n";
}
// 3) menus
foreach($menus as $slug=>$src){
  $enslug=$slug.'-en';
  if(get_term_by('slug',$enslug,'nav_menu')){echo "menu $enslug exists\n";continue;}
  $mid=wp_update_nav_menu_object(0,['menu-name'=>$src->name.' (EN)']);if(is_wp_error($mid)){echo 'menu err '.$mid->get_error_message()."\n";continue;}
  wp_update_term($mid,'nav_menu',['slug'=>$enslug]);
  $idmap=[];
  foreach(wp_get_nav_menu_items($src->term_id,['post_status'=>'any']) as $it){
    $args=['menu-item-status'=>'publish','menu-item-position'=>$it->menu_order,'menu-item-classes'=>implode(' ',array_filter((array)$it->classes)),'menu-item-target'=>$it->target,'menu-item-parent-id'=>$idmap[$it->menu_item_parent]??0,'menu-item-title'=>$it->post_title!==''?($dict[$norm($it->post_title)]??$it->post_title):''];
    if($it->type==='post_type'){$args+=['menu-item-type'=>'post_type','menu-item-object'=>$it->object,'menu-item-object-id'=>pll_get_post($it->object_id,'en')?:$it->object_id];}
    else{$args+=['menu-item-type'=>'custom','menu-item-url'=>$mapurl($it->url)];if($args['menu-item-title']==='')$args['menu-item-title']=$dict[$norm($it->title)]??$it->title;}
    $idmap[$it->ID]=wp_update_nav_menu_item($mid,0,$args);
  }
  echo "menu $enslug: ".implode(' | ',array_map(function($i){return $i->title.' => '.$i->url;},wp_get_nav_menu_items($mid)))."\n";
}
// 4) Dutch header switcher: real fallback links (NL active)
$h=json_decode(get_post_meta(49,'_elementor_data',true),true);
$fix=function($els)use(&$fix,$S){foreach($els as &$e){if(($e['id']??'')==='f7a89ab')$e['settings']['editor']='<a class="vt-lang__opt is-active" href="'.$S.'/" lang="nl" hreflang="nl" aria-current="true">NL</a><a class="vt-lang__opt" href="'.$S.'/en/" lang="en" hreflang="en">EN</a>';if(!empty($e['elements']))$e['elements']=$fix($e['elements']);}return $els;};
update_post_meta(49,'_elementor_data',wp_slash(wp_json_encode($fix($h))));
// 5) vt.js: bilingual form messages + switcher follows the current page's translation
$js=get_stylesheet_directory().'/assets/vt.js';$s=file_get_contents($js);$c=0;
$s=str_replace("card.innerHTML = '<div class=\"vt-form-thanks\"><b>✓</b><strong>Bedankt voor uw bericht</strong></div>';","card.innerHTML = '<div class=\"vt-form-thanks\"><b>✓</b><strong>' + (en ? 'Thank you for your message' : 'Bedankt voor uw bericht') + '</strong></div>';",$s,$n1);
$s=str_replace("p.textContent = 'Sorry, uw bericht kon niet worden verzonden. Mail ons op info@vthullenaar.nl.';","p.textContent = en ? 'Sorry, your message could not be sent. Email us at info@vthullenaar.nl.' : 'Sorry, uw bericht kon niet worden verzonden. Mail ons op info@vthullenaar.nl.';",$s,$n2);
$s=str_replace("if (!m || !form) { return; }","if (!m || !form) { return; }\n\t\tvar en = /^en/i.test(document.documentElement.lang || '');",$s,$n3);
if(strpos($s,'vt-lang__opt[lang]')===false)$s.=<<<'VTJS'

/* vtHullenaar: NL | EN switcher links to the translation of the current page (Polylang hreflang alternates). */
(function () {
	'use strict';
	function ready(fn) { if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
	ready(function () {
		document.querySelectorAll('.vt-lang__opt[lang]').forEach(function (a) {
			var alt = document.querySelector('link[rel="alternate"][hreflang^="' + a.getAttribute('lang') + '"]');
			if (alt && alt.href) { a.href = alt.href; }
		});
	});
})();
VTJS;
echo "vt.js replacements: $n1 $n2 $n3\n";
if($n1===1&&$n2===1&&$n3===1)file_put_contents($js,$s);else echo "vt.js NOT written\n";
// 6) caches
foreach(array_merge([49],array_values($made)) as $id){delete_post_meta($id,'_elementor_css');delete_post_meta($id,'_elementor_element_cache');}
if(class_exists('\Elementor\Plugin'))\Elementor\Plugin::$instance->files_manager->clear_cache();
delete_option('rewrite_rules');
echo 'translated strings: '.count($hit).'/'.count($dict)."\n";
echo "not in dictionary (kept as is):\n";foreach(array_keys($miss) as $m)echo '  '.mb_substr($m,0,120)."\n";
echo 'blogdescription: '.get_option('blogdescription').' | sync: '.json_encode(get_option('polylang')['sync']??null)."\n";
