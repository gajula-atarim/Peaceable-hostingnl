function vt_cta(){
  $card=vt_row([vt_h('Complete care from <strong>patch panel to workspace</strong>','h2','#FFFFFF','',['size'=>50,'tablet'=>40,'mobile'=>30,'weight'=>400,'lh'=>1.08,'ls'=>-1.6],['_flex_size'=>'grow']),
    vt_btn('Get in touch →','PAGE:contact','',['pad'=>[16,28],'size'=>16])],'vt-cta-card',28,true,true,['flex_justify_content'=>'space-between','align'=>'center','content_width'=>'boxed','boxed_width'=>vt_px(1280),'padding'=>vt_box(64),'padding_mobile'=>vt_box(36,24),'background_background'=>'classic','background_color'=>'#0B1A3A','border_radius'=>vt_box(28),'flex_align_items_mobile'=>'flex-start']);
  return vt_con([$card],'vt-cta',['html_tag'=>'section','padding'=>vt_box(40,20,120,20),'background_background'=>'classic','background_color'=>'#FFFFFF']);
}
function vt_arrow_btn($label,$url,$cls='vt-btn-arrow vt-btn-arrow--white'){return vt_btn($label,$url,$cls,['bg'=>'#1F7FC4','fg'=>'#FFFFFF','hbg'=>'#0B1A3A','hfg'=>'#FFFFFF','pad'=>[8,8],'icon'=>'fas fa-arrow-right']);}
function vt_page_services(){
  $SV=[['01','Patch cabinet','Data networks','svc_data','fas fa-ethernet','High-quality, future-proof, and organized network connections are the foundation of a well-functioning business network — and that is our specialty. We install copper or fiber optic cabling to standards and deliver only when you are satisfied.'],
    ['02','Wireless network','Wireless networks','svc_wifi','fas fa-broadcast-tower','Want to connect two of your locations without cabling? Or need stable WiFi coverage across your entire premises? We realize wireless networks that are reliable and secure.'],
    ['03','Camera security','Camera security','svc_cam','fas fa-video','A safe work environment starts with good security. We install professional camera systems that connect to your network and ensure optimal monitoring of your business premises.'],
    ['04','Secondment of network technicians','Staffing','svc_staff','fas fa-user-check','Do you temporarily need extra capacity for a large project? We provide staffing of experienced network technicians who are immediately deployable and think along with your organization.']];
  $out=vt_inner('Our services <strong>at a glance</strong>','Services','Complete care from patch panel to workspace.');
  $chips=[];foreach($SV as $s)$chips[]=vt_btn($s[0].'  '.$s[2],'#svc-'.$s[0],'vt-subnav-chip',['bg'=>'#F1F4F9','fg'=>'#0B1A3A','hbg'=>'#0B1A3A','hfg'=>'#FFFFFF','pad'=>[9,16],'size'=>14]);
  $out[]=vt_con([vt_row($chips,'',10,true,false,['content_width'=>'boxed','boxed_width'=>vt_px(1280),'padding'=>vt_box(14,40),'padding_mobile'=>vt_box(12,16)])],'vt-subnav',['html_tag'=>'nav']);
  foreach($SV as $i=>[$n,$label,$title,$key,$ic,$body]){
    $media=vt_con([vt_h($label,'div','#0B1A3A','vt-media-chip',['size'=>13,'weight'=>600]),vt_h($n,'div','#FFFFFF','vt-outline-num vt-media-num',['size'=>120,'tablet'=>96,'mobile'=>80,'weight'=>700,'lh'=>1,'ls'=>-6])],'vt-svc-media',array_merge(['flex_justify_content'=>'space-between','flex_align_items'=>'flex-start','padding'=>vt_box(18,18,6,18),'background_background'=>'classic','background_image'=>vt_img($key),'background_position'=>'center center','background_size'=>'cover','border_radius'=>vt_box(28)],vt_pct(50)));
    $copy=vt_con([vt_icon($ic,'vt-square-icon vt-icon-60',['size'=>22,'pad'=>19]),vt_pill($label),vt_h($title,'h2','#0B1A3A','',['size'=>56,'tablet'=>44,'mobile'=>36,'weight'=>700,'lh'=>1.05,'ls'=>-2]),
      vt_t('<p>'.$body.'</p>','#4A5A70','',['size'=>18,'lh'=>1.7]),vt_arrow_btn('Get in touch','PAGE:contact')],'',array_merge(['flex_gap'=>vt_gap(22),'flex_align_items'=>'flex-start'],vt_pct(50)));
    $kids=$i%2==0?[$media,$copy]:[$copy,$media];
    $out[]=vt_section([vt_row($kids,'',64,false,true,['align'=>'center'])],'','svc-'.$n,['padding'=>vt_box(110,40)],$i%2==0?'#FFFFFF':'#F4F7FB');
  }
  $out[]=vt_cta();
  return $out;
}
function vt_page_projects(){
  $out=vt_inner('Our <strong>projects</strong>','Projects');
  $top=vt_row([vt_row([vt_h('08','div','#1F7FC4','vt-outline-num vt-outline-num--blue',['size'=>72,'weight'=>700,'lh'=>0.9,'ls'=>-4]),vt_t('<p>projects in<br>the gallery</p>','#4A5A70','',['size'=>15,'lh'=>1.4])],'',14,true,false,['align'=>'flex-end']),
    vt_btn('Open gallery','#','vt-btn-arrow vt-open-gallery',['bg'=>'#0B1A3A','fg'=>'#FFFFFF','hbg'=>'#1F7FC4','hfg'=>'#FFFFFF','pad'=>[8,8],'icon'=>'fas fa-expand-alt'])],'',20,true,false,['flex_justify_content'=>'space-between']);
  $rows=[2,1,1,2,1,2,1,1];$tiles=[];
  foreach($rows as $i=>$r)$tiles[]=vt_image('prj'.($i+1),'vt-mtile'.($r==2?' vt-span2':''),[],true,'large');
  $tiles[]=vt_con([vt_h('Your project <strong>here?</strong>','div','#FFFFFF','',['size'=>26,'weight'=>400,'ls'=>-0.5]),vt_h('Contact us →','div','#FFFFFF','',['size'=>15,'weight'=>600])],'vt-project-card',['html_tag'=>'a','link'=>vt_link('PAGE:contact'),'flex_justify_content'=>'space-between','padding'=>vt_box(26),'border_radius'=>vt_box(22),'background_background'=>'classic','background_color'=>'#0B1A3A']);
  $out[]=vt_section([$top,vt_con($tiles,'vt-masonry')],'vt-gallery','gallery',['flex_gap'=>vt_gap(40),'padding'=>vt_box(100,40,60,40)],'#FFFFFF');
  $out[]=vt_cta();
  return $out;
}
function vt_page_about(){
  $out=vt_inner('Who we are','About us','Everything we do revolves around connection — literally and figuratively.');
  $F=[['fas fa-server','We are a dedicated and skilled installer specializing in the installation, optimization, and maintenance of structured data networks.'],
    ['fas fa-user-check','What sets us apart is not only our technical expertise but also our personal approach. We think along with you and deliver solutions you can rely on — from fiber optic networks to WiFi access points, from patch panels to cable trays.'],
    ['fas fa-star','vtHullenaar BV was born from a passion for the craft and reliability. What started as a sole proprietorship has grown into a solid corporation with a clear mission: providing clients with high-quality, stable, and professional network solutions.']];
  $cards=[];foreach($F as [$ic,$t])$cards[]=vt_con([vt_icon($ic,'',['size'=>20,'pad'=>16]),vt_t('<p>'.$t.'</p>','#4A5A70','',['size'=>17,'lh'=>1.65])],'vt-icon-row',['flex_direction'=>'row','flex_gap'=>vt_gap(20),'padding'=>vt_box(26),'border_radius'=>vt_box(22),'background_background'=>'classic','background_color'=>'#F4F7FB','flex_align_items'=>'flex-start']);
  $left=vt_con(array_merge([vt_pill('Who we are'),vt_h('We are a dedicated and skilled <strong>installer</strong>','h2','#0B1A3A','',['size'=>52,'tablet'=>40,'mobile'=>32,'weight'=>400,'lh'=>1.12,'ls'=>-1.6])],$cards),'',array_merge(['flex_gap'=>vt_gap(16)],vt_pct(50)));
  $right=vt_con([vt_image('who3','vt-photo-r vt-ratio-tall'),vt_con([vt_image('who1','vt-photo-r vt-ratio-square'),
    vt_con([vt_h('vtHullenaar activities','div','#3FA9F5','',['size'=>12,'weight'=>700,'ls'=>1.4,'transform'=>'uppercase']),vt_h('COMPLETE CARE FROM PATCH PANEL TO WORKSPACE!','div','#FFFFFF','',['size'=>15,'weight'=>600,'lh'=>1.35])],'',['flex_gap'=>vt_gap(8),'padding'=>vt_box(22),'border_radius'=>vt_box(24),'background_background'=>'classic','background_color'=>'#0B1A3A'])],'vt-about-col2',['flex_gap'=>vt_gap(16),'padding'=>vt_box(64,0,0,0)])],
    'vt-about-photos',array_merge(['flex_direction'=>'row','flex_gap'=>vt_gap(16),'flex_align_items'=>'flex-start','flex_direction_mobile'=>'row'],vt_pct(50)));
  $out[]=vt_section([vt_row([$left,$right],'',56,false,true,['align'=>'center'])],'','who',['padding'=>vt_box(100,40)],'#FFFFFF');
  $grad=vt_con([vt_icon('fas fa-check','vt-ring-outline',['view'=>'framed','size'=>18,'pad'=>11]),vt_h('Everything installed to current standards, clearly coded, tested, and delivered operational.','div','#FFFFFF','',['size'=>17,'weight'=>600,'lh'=>1.45])],'vt-grad-card vt-icon-row',['flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(16),'padding'=>vt_box(24),'border_radius'=>vt_box(22),'background_background'=>'gradient','background_color'=>'#3FA9F5','background_color_stop'=>vt_u('%',0),'background_color_b'=>'#1F7FC4','background_color_b_stop'=>vt_u('%',100),'background_gradient_angle'=>vt_u('deg',140)]);
  $p=function($t){return vt_t('<p>'.$t.'</p>','#4A5A70','',['size'=>18,'lh'=>1.7]);};
  $out[]=vt_section([vt_row([
    vt_con([vt_pill('What we do'),vt_h('Reliable and professional <strong>network solutions</strong>','h2','#0B1A3A','',['size'=>60,'tablet'=>44,'mobile'=>34,'weight'=>400,'lh'=>1.08,'ls'=>-2]),vt_h('Just as it should be!','div','#1F7FC4','',['size'=>26,'weight'=>700,'ls'=>-0.5])],'vt-sticky',array_merge(['flex_gap'=>vt_gap(22)],vt_pct(50))),
    vt_con([$p('We provide reliable and professional network solutions, from design to delivery. Whether it involves a completely new network, expanding existing infrastructure, or resolving faults — we handle it.'),$p('We work with all types of companies across every imaginable sector and deliver tailored solutions with an eye for quality and detail, combining technical precision with a practical approach.'),$grad,$p('Choosing us means choosing quality, clarity, and service you can count on.')],'',array_merge(['flex_gap'=>vt_gap(18)],vt_pct(50)))],
    '',56,false,true,['align'=>'flex-start'])],'','what',['padding'=>vt_box(110,40)],'#F4F7FB');
  $Q=[['"vtHullenaar completely relieved us during the installation of our new data network. From advice to delivery — everything perfectly arranged and installed to standards."','— Client','#0B1A3A','#FFFFFF','#3FA9F5','#8FD0FF'],
    ['"Professional, dedicated, and skilled. They think along with you and deliver quality you can rely on. Exactly what you are looking for in a business network partner."','— Customer vtHullenaar','#EEF4FB','#0B1A3A','#1F7FC4','#1F7FC4']];
  $qc=[];foreach($Q as [$q,$a,$bg,$fg,$star,$cap])$qc[]=vt_con([vt_h('★★★★★','div',$star,'',['size'=>18]),vt_t('<p>'.$q.'</p>',$fg,'',['size'=>21,'mobile'=>19,'weight'=>500,'lh'=>1.5]),vt_h($a,'div',$cap,'',['size'=>16,'weight'=>600])],'',array_merge(['flex_gap'=>vt_gap(24),'padding'=>vt_box(40),'padding_mobile'=>vt_box(28),'border_radius'=>vt_box(28),'background_background'=>'classic','background_color'=>$bg],vt_pct(50)));
  $out[]=vt_section([vt_pill('Testimonials'),vt_h('What clients <strong>say</strong>','h2','#0B1A3A','',['size'=>60,'tablet'=>44,'mobile'=>34,'weight'=>400,'lh'=>1.08,'ls'=>-2]),vt_row($qc,'',20,false,true,['align'=>'stretch'])],'','testimonials',['flex_gap'=>vt_gap(24),'padding'=>vt_box(110,40,40,40)],'#FFFFFF');
  $out[]=vt_cta();
  return $out;
}
function vt_page_contact($formId){
  $out=vt_inner('Get in touch','Contact');
  $card=function($ic,$label,$value,$url=null){$s=['flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(18),'padding'=>vt_box(22),'border_radius'=>vt_box(22),'background_background'=>'classic','background_color'=>'#F4F7FB','border_border'=>'solid','border_width'=>vt_box(1),'border_color'=>'#E1E7EF'];if($url){$s['html_tag']='a';$s['link']=vt_link($url);}
    return vt_con([vt_icon($ic,'',['size'=>20,'pad'=>16]),vt_con([vt_h($label,'div','#4A5A70','',['size'=>13,'weight'=>400]),vt_h($value,'div','#0B1A3A','',['size'=>19,'weight'=>600])],'',['flex_gap'=>vt_gap(3)])],'vt-contact-card-row vt-icon-row',$s);};
  $left=vt_con([vt_pill('Contact'),vt_h('Complete care from <strong>patch panel to workspace</strong>','h2','#0B1A3A','',['size'=>52,'tablet'=>40,'mobile'=>32,'weight'=>400,'lh'=>1.1,'ls'=>-1.6]),
    $card('fas fa-phone-alt','Phone','(0031) 182 700 616','tel:0031182700616'),$card('fas fa-envelope','E-mail','info@vthullenaar.nl','mailto:info@vthullenaar.nl'),$card('fas fa-map-marker-alt','Address','Zernikelaan 47, 2871 LP Schoonhoven'),
    vt_row([vt_h('Follow us','div','#0B1A3A','',['size'=>14,'weight'=>600]),vt_btn('Facebook','#','',['bg'=>'transparent','fg'=>'#0B1A3A','hbg'=>'#0B1A3A','hfg'=>'#FFFFFF','pad'=>[9,16],'size'=>14,'border'=>'#D5DEE9'])],'',10,true,false)],
    '',array_merge(['flex_gap'=>vt_gap(18)],vt_pct(50)));
  $right=vt_con([vt_h('Email us','h3','#0B1A3A','',['size'=>26,'weight'=>700,'ls'=>-0.5]),vt_w('shortcode','vt-form',['shortcode'=>'[contact-form-7 id="'.$formId.'" title="Contact"]'])],'vt-form-card',array_merge(['flex_gap'=>vt_gap(16),'padding'=>vt_box(44),'padding_mobile'=>vt_box(28),'border_radius'=>vt_box(28),'background_background'=>'classic','background_color'=>'#F4F7FB','border_border'=>'solid','border_width'=>vt_box(1),'border_color'=>'#E1E7EF'],vt_pct(50)));
  $map=vt_con([vt_w('google_maps','',['address'=>'Zernikelaan 47, 2871 LP Schoonhoven','zoom'=>vt_px(15),'height'=>vt_px(380)])],'vt-map',['border_radius'=>vt_box(28),'border_border'=>'solid','border_width'=>vt_box(1),'border_color'=>'#E1E7EF']);
  $out[]=vt_section([vt_row([$left,$right],'',48,false,true,['align'=>'flex-start']),$map],'','contact-form',['flex_gap'=>vt_gap(48),'padding'=>vt_box(100,40,40,40)],'#FFFFFF');
  $out[]=vt_con([],'',['padding'=>vt_box(40,0,0,0),'background_background'=>'classic','background_color'=>'#FFFFFF']);
  return $out;
}
function vt_page_terms(){
  $out=vt_inner('Terms &amp; conditions','Terms');
  $dl=vt_con([vt_h('PDF','div','#FFFFFF','vt-pdf-badge',['size'=>12,'weight'=>700,'ls'=>0.7]),
    vt_con([vt_h('Download terms (PDF)','div','#0B1A3A','',['size'=>18,'weight'=>600]),vt_h('ALIB 2024 · Techniek Nederland','div','#4A5A70','',['size'=>14,'weight'=>400])],'',['flex_gap'=>vt_gap(3)]),
    vt_h('↓','div','#FFFFFF','vt-dl-arrow',['size'=>18])],'vt-download vt-icon-row',['html_tag'=>'a','link'=>vt_link('#'),'flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(18),'padding'=>vt_box(20,22),'border_radius'=>vt_box(22),'background_background'=>'classic','background_color'=>'#F4F7FB','border_border'=>'solid','border_width'=>vt_box(1),'border_color'=>'#E1E7EF']);
  $out[]=vt_section([vt_pill('Terms'),vt_con([vt_h('General Terms and Conditions','h2','#0B1A3A','',['size'=>44,'mobile'=>30,'weight'=>700,'lh'=>1.1,'ls'=>-1.3]),vt_h('vtHullenaar B.V.','div','#1F7FC4','',['size'=>18,'weight'=>600])],'',['flex_gap'=>vt_gap(6)]),
    vt_t('<p>vtHullenaar B.V. applies the General Delivery Conditions for Installing Companies 2024 (ALIB 2024) by Techniek Nederland to all its work and deliveries. These conditions transparently describe the rights and obligations of both client and contractor.</p>','#4A5A70','',['size'=>18,'lh'=>1.75]),$dl],
    '','terms',['flex_gap'=>vt_gap(24),'boxed_width'=>vt_px(860),'padding'=>vt_box(100,40,120,40)],'#FFFFFF');
  return $out;
}
