$NAVY='#0B1A3A';$BLUE='#1F7FC4';$SKY='#3FA9F5';$INK='#050B18';$TEXT='#4A5A70';$MUTED='#AFC0D4';$LIGHT='#F4F7FB';$LINE='#E1E7EF';
function vt_id(){return substr(md5(uniqid('',true).mt_rand()),0,7);}
function vt_px($v){return ['unit'=>'px','size'=>$v,'sizes'=>[]];}
function vt_u($u,$v){return ['unit'=>$u,'size'=>$v];}
function vt_box($t,$r=null,$b=null,$l=null){$r=$r??$t;$b=$b??$t;$l=$l??$r;return ['unit'=>'px','top'=>(string)$t,'right'=>(string)$r,'bottom'=>(string)$b,'left'=>(string)$l,'isLinked'=>count(array_unique([$t,$r,$b,$l]))==1];}
function vt_gap($v){return ['unit'=>'px','size'=>$v,'column'=>(string)$v,'row'=>(string)$v,'isLinked'=>true];}
function vt_link($u){return ['url'=>$u,'is_external'=>'','nofollow'=>'','custom_attributes'=>''];}
function vt_img($k){return ['id'=>'IMG:'.$k,'url'=>'IMG:'.$k,'alt'=>'','source'=>'library'];}
function vt_w100(){return ['width_mobile'=>vt_u('%',100)];}
function vt_typo($o){
  $s=['typography_typography'=>'custom','typography_font_family'=>'Archivo'];
  if(isset($o['size']))$s['typography_font_size']=vt_px($o['size']);
  if(isset($o['tablet']))$s['typography_font_size_tablet']=vt_px($o['tablet']);
  if(isset($o['mobile']))$s['typography_font_size_mobile']=vt_px($o['mobile']);
  if(isset($o['weight']))$s['typography_font_weight']=(string)$o['weight'];
  if(isset($o['lh']))$s['typography_line_height']=['unit'=>'em','size'=>$o['lh'],'sizes'=>[]];
  if(isset($o['ls']))$s['typography_letter_spacing']=vt_px($o['ls']);
  if(!empty($o['transform']))$s['typography_text_transform']=$o['transform'];
  return $s;
}
function vt_con($kids,$cls='',$s=[]){
  $st=array_merge(['content_width'=>'full','flex_direction'=>'column','padding'=>vt_box(0)],$s);
  if($cls)$st['css_classes']=$cls;
  return ['id'=>vt_id(),'elType'=>'container','isInner'=>false,'settings'=>$st,'elements'=>$kids];
}
function vt_row($kids,$cls='',$g=24,$wrap=true,$mcol=true,$s=[]){
  $d=['flex_direction'=>'row','flex_gap'=>vt_gap($g),'flex_align_items'=>$s['align']??'center'];unset($s['align']);
  if($wrap)$d['flex_wrap']='wrap';
  if($mcol){$d['flex_direction_mobile']='column';$d['flex_align_items_mobile']='stretch';}
  return vt_con($kids,$cls,array_merge($d,$s));
}
function vt_section($kids,$cls='',$sid='',$s=[],$bg=null,$pad=[120,40,120,40]){
  $d=['content_width'=>'boxed','boxed_width'=>vt_px(1280),'flex_direction'=>'column','padding'=>vt_box(...$pad),'padding_mobile'=>vt_box(80,20,80,20),'html_tag'=>'section'];
  if($bg){$d['background_background']='classic';$d['background_color']=$bg;}
  if(strpos($cls,'vt-dark')!==false)$d=array_merge($d,['background_background'=>'gradient','background_gradient_type'=>'radial','background_gradient_position'=>'top right','background_color'=>'#123A6E','background_color_stop'=>vt_u('%',0),'background_color_b'=>'#040B1A','background_color_b_stop'=>vt_u('%',100)]);
  if($sid)$d['_element_id']=$sid;
  return vt_con($kids,$cls,array_merge($d,$s));
}
function vt_w($type,$cls,$s){if($cls)$s['_css_classes']=$cls;return ['id'=>vt_id(),'elType'=>'widget','widgetType'=>$type,'isInner'=>false,'settings'=>$s,'elements'=>[]];}
function vt_h($title,$tag='h2',$color='#0B1A3A',$cls='',$o=[],$extra=[]){
  $s=array_merge(['title'=>$title,'header_size'=>$tag,'title_color'=>$color],vt_typo($o),$extra);
  return vt_w('heading',$cls,$s);
}
function vt_t($html,$color='#4A5A70',$cls='',$o=[]){return vt_w('text-editor',$cls,array_merge(['editor'=>$html,'text_color'=>$color],vt_typo($o)));}
function vt_btn($label,$url,$cls='',$o=[]){
  $o=array_merge(['bg'=>'#3FA9F5','fg'=>'#050B18','hbg'=>'#FFFFFF','hfg'=>'#050B18','radius'=>999,'pad'=>[14,26],'size'=>15,'border'=>null,'icon'=>null],$o);
  $s=['text'=>$label,'link'=>vt_link($url),'background_background'=>'classic','background_color'=>$o['bg'],'button_text_color'=>$o['fg'],'button_background_hover_background'=>'classic','button_background_hover_color'=>$o['hbg'],'hover_color'=>$o['hfg'],'border_radius'=>vt_box($o['radius']),'text_padding'=>vt_box($o['pad'][0],$o['pad'][1])];
  $s=array_merge($s,vt_typo(['size'=>$o['size'],'weight'=>600,'lh'=>1.2]));
  if($o['border'])$s=array_merge($s,['border_border'=>'solid','border_width'=>vt_box(1),'border_color'=>$o['border'],'button_hover_border_color'=>$o['hbg']!=='transparent'?$o['border']:'#3FA9F5']);
  if($o['icon'])$s=array_merge($s,['selected_icon'=>['value'=>$o['icon'],'library'=>'fa-solid'],'icon_align'=>'row-reverse','icon_indent'=>vt_px(10)]);
  return vt_w('button',$cls,$s);
}
function vt_icon($v,$cls='',$o=[]){
  $o=array_merge(['color'=>'#FFFFFF','bg'=>'#0B1A3A','size'=>20,'pad'=>14,'view'=>'stacked'],$o);
  $s=['selected_icon'=>['value'=>$v,'library'=>'fa-solid'],'view'=>$o['view'],'shape'=>'circle','primary_color'=>$o['view']=='stacked'?$o['bg']:$o['color'],'secondary_color'=>$o['color'],'size'=>vt_px($o['size']),'icon_padding'=>vt_px($o['pad']),'align'=>'left'];
  return vt_w('icon',$cls,$s);
}
function vt_image($k,$cls='',$s=[],$file=false,$size='large'){
  $d=['image'=>vt_img($k),'image_size'=>$size,'align'=>'center'];
  if($file){$d['link_to']='file';$d['open_lightbox']='yes';}
  return vt_w('image',$cls,array_merge($d,$s));
}
function vt_pill($label,$dark=false){return vt_h($label,'div',$dark?'#FFFFFF':'#0B1A3A','vt-pill'.($dark?' vt-pill--dark':''),['size'=>12,'weight'=>600,'ls'=>1,'transform'=>'uppercase','lh'=>1.2]);}
function vt_nav($slug,$layout='horizontal',$cls='vt-nav'){
  $s=['menu'=>$slug,'layout'=>$layout,'navmenu_align'=>'center','submenu_icon'=>'arrow','dropdown'=>$layout=='horizontal'?'tablet':'none','resp_align'=>'left','full_width_dropdown'=>'yes','toggle_size'=>vt_px(22),'padding_horizontal_menu_item'=>vt_px(16),'padding_vertical_menu_item'=>vt_px(9),'menu_space_between'=>vt_px(4),'color_menu_item'=>'#C9D6E6','color_menu_item_hover'=>'#FFFFFF','color_menu_item_active'=>'#FFFFFF','toggle_color'=>'#FFFFFF','menu_typography_typography'=>'custom','menu_typography_font_family'=>'Archivo','menu_typography_font_size'=>vt_px(15),'menu_typography_font_weight'=>'500','color_dropdown_item'=>'#FFFFFF','background_color_dropdown_item'=>'#0B1A3A','color_dropdown_item_hover'=>'#3FA9F5','background_color_dropdown_item_hover'=>'#0B1A3A','_flex_size'=>'grow'];
  if($layout=='vertical')$s=array_merge($s,['navmenu_align'=>'left','padding_horizontal_menu_item'=>vt_px(0),'padding_vertical_menu_item'=>vt_px(6),'menu_space_between'=>vt_px(0),'color_menu_item'=>'#A9B8CA','color_menu_item_hover'=>'#3FA9F5','color_menu_item_active'=>'#A9B8CA']);
  return vt_w('navigation-menu',$cls,$s);
}
function vt_ilist($items,$cls,$color,$ic,$size=15,$weight=500){
  $list=[];foreach($items as [$t,$i])$list[]=['_id'=>vt_id(),'text'=>$t,'selected_icon'=>['value'=>$i,'library'=>'fa-solid']];
  return vt_w('icon-list',$cls,['view'=>'inline','icon_align'=>'center','icon_list'=>$list,'icon_color'=>$ic,'text_color'=>$color,'icon_size'=>vt_px(18),'text_indent'=>vt_px(10),'icon_typography_typography'=>'custom','icon_typography_font_family'=>'Archivo','icon_typography_font_size'=>vt_px($size),'icon_typography_font_weight'=>(string)$weight]);
}
function vt_pct($p,$m=true){$a=['width'=>vt_u('%',$p)];if($m)$a['width_mobile']=vt_u('%',100);return $a;}

function vt_header(){
  $logo=vt_image('logo','vt-logo-box',['link_to'=>'custom','link'=>vt_link('PAGE:home'),'align'=>'left'],false,'full');
  $lang=vt_t('<a class="vt-lang__opt is-active" href="#" lang="nl" aria-current="true">NL</a><a class="vt-lang__opt" href="#" lang="en">EN</a>','#C9D6E6','vt-lang',['size'=>13,'weight'=>600]);
  $cta=vt_btn('Neem contact op','PAGE:contact','vt-header-cta',['pad'=>[12,22]]);
  $bar=vt_row([$logo,vt_nav('vt-main-menu'),$lang,$cta],'vt-header-bar',32,false,false,['flex_justify_content'=>'space-between','content_width'=>'boxed','boxed_width'=>vt_px(1440),'padding'=>vt_box(16,40),'padding_mobile'=>vt_box(12,16),'flex_gap_mobile'=>vt_gap(12),'flex_wrap_tablet'=>'nowrap']);
  return [vt_con([$bar],'vt-header',['html_tag'=>'header'])];
}
function vt_flist($items){
  $list=[];foreach($items as [$t,$i,$lib,$url,$ext]){$l=vt_link($url);$l['is_external']=$ext?'on':'';$list[]=['_id'=>vt_id(),'text'=>$t,'selected_icon'=>['value'=>$i,'library'=>$lib],'link'=>$l];}
  return vt_w('icon-list','vt-footer-icons',['view'=>'traditional','icon_list'=>$list,'space_between'=>vt_px(12),'icon_size'=>vt_px(14),'text_indent'=>vt_px(10),'icon_color'=>'#3FA9F5','text_color'=>'#A9B8CA','text_color_hover'=>'#3FA9F5','icon_typography_typography'=>'custom','icon_typography_font_family'=>'Archivo','icon_typography_font_size'=>vt_px(15),'icon_typography_font_weight'=>'400','icon_typography_line_height'=>vt_u('em',1.6)]);
}
function vt_footer(){
  $brand=vt_con([vt_image('logo','vt-logo-box vt-logo-box--sm',['link_to'=>'custom','link'=>vt_link('PAGE:home'),'align'=>'left'],false,'full'),vt_h('vtHullenaar BV','div','#FFFFFF','',['size'=>17,'weight'=>600]),vt_t('<p>Professionele installateur van datanetwerken, draadloze verbindingen en camerabeveiligings&shy;systemen.</p>','#A9B8CA','',['size'=>15,'lh'=>1.6])],'vt-footer-col',array_merge(['flex_gap'=>vt_gap(20)],vt_pct(30)));
  $pages=vt_con([vt_h('Pagina\'s','div','#FFFFFF','',['size'=>15,'weight'=>600]),vt_nav('vt-footer-menu','vertical','vt-footer-nav')],'vt-footer-col',array_merge(['flex_gap'=>vt_gap(12)],vt_pct(20)));
  $contact=vt_con([vt_h('Contact','div','#FFFFFF','',['size'=>15,'weight'=>600]),vt_flist([['(0031) 182 700 616','fas fa-phone-alt','fa-solid','tel:0031182700616',false],['info@vthullenaar.nl','fas fa-envelope','fa-solid','mailto:info@vthullenaar.nl',false],['Zernikelaan 47, 2871 LP Schoonhoven','fas fa-map-marker-alt','fa-solid','https://www.google.com/maps/search/?api=1&query=Zernikelaan%2047%2C%202871%20LP%20Schoonhoven',true]])],'vt-footer-col',array_merge(['flex_gap'=>vt_gap(12)],vt_pct(25)));
  $follow=vt_con([vt_h('Volg ons','div','#FFFFFF','',['size'=>15,'weight'=>600]),vt_flist([['Facebook','fab fa-facebook-f','fa-brands','#',false],['LinkedIn','fab fa-linkedin-in','fa-brands','#',false]])],'vt-footer-col',array_merge(['flex_gap'=>vt_gap(12)],vt_pct(15)));
  $cols=vt_row([$brand,$pages,$contact,$follow],'',48,true,true,['align'=>'flex-start','flex_wrap'=>'nowrap','flex_wrap_tablet'=>'wrap','flex_justify_content'=>'space-between']);
  $bottom=vt_row([vt_t('<p>© 2026 vtHullenaar BV Alle rechten voorbehouden</p>','#A9B8CA','',['size'=>14]),vt_t('<p><a href="PAGE:terms">Algemene voorwaarden</a></p>','#A9B8CA','vt-footer-links',['size'=>14])],'vt-footer-bottom',20,true,false,['flex_justify_content'=>'space-between']);
  return [vt_con([$cols,$bottom],'vt-footer',['html_tag'=>'footer','content_width'=>'boxed','boxed_width'=>vt_px(1440),'padding'=>vt_box(96,40,40,40),'padding_mobile'=>vt_box(64,20,32,20),'flex_gap'=>vt_gap(72),'background_background'=>'classic','background_color'=>'#050B18'])];
}
function vt_home(){
  $NAVY='#0B1A3A';$BLUE='#1F7FC4';$SKY='#3FA9F5';$TEXT='#4A5A70';$MUTED='#AFC0D4';
  $SV=[['01','Patchkast','Data&shy;netwerken','svc_data','fas fa-server','Hoogwaardige, toekomstbestendige en overzichtelijke netwerkverbindingen vormen de basis van een goed functionerend bedrijfsnetwerk — en dat is onze specialiteit. Wij leggen koper- of glasvezelbekabeling aan volgens de normen en leveren pas op als u tevreden bent.'],
    ['02','Draadloos netwerk','Draadloze netwerken','svc_wifi','fas fa-broadcast-tower','Wilt u twee van uw locaties zonder bekabeling met elkaar verbinden? Of heeft u stabiele wifi-dekking nodig op uw hele terrein? Wij realiseren draadloze netwerken die betrouwbaar en veilig zijn.'],
    ['03','Camera&shy;beveiliging','Camera&shy;beveiliging','svc_cam','fas fa-video','Een veilige werkomgeving begint bij goede beveiliging. Wij installeren professionele camerasystemen die aansluiten op uw netwerk en zorgen voor optimaal toezicht op uw bedrijfspand.'],
    ['04','Glasvezel','Glasvezel&shy;netwerken','svc_staff','fas fa-stream','Snel, stabiel en klaar voor de toekomst. Wij leggen glasvezelverbindingen aan binnen en tussen uw gebouwen — inclusief lassen, afmonteren en doormeten — en leveren alles getest en gedocumenteerd op.']];
  $out=[];
  // 1 hero
  $tabs=[];foreach($SV as $s)$tabs[]=vt_con([vt_con([vt_h($s[0],'div','#8FA3BA','',['size'=>13,'weight'=>400]),vt_h($s[2],'div','#FFFFFF','',['size'=>19,'weight'=>500,'ls'=>-0.2])],'',['flex_gap'=>vt_gap(6)]),vt_h('↗','div','#FFFFFF','vt-hero-tab__arrow',['size'=>22])],'vt-hero-tab',['flex_direction'=>'row','flex_justify_content'=>'space-between','flex_align_items'=>'center','html_tag'=>'a','link'=>vt_link('#services'),'padding'=>vt_box(26,24,30,0),'flex_gap'=>vt_gap(16)]);
  $copy=vt_con([vt_h('vtHullenaar BV · Betrouwbare netwerk&shy;oplossingen','div',$SKY,'vt-eyebrow',['size'=>14,'weight'=>600,'ls'=>2,'transform'=>'uppercase']),
    vt_h('Complete ontzorging van patchpaneel tot werkplek','h1','#FFFFFF','vt-hero-title',['size'=>100,'tablet'=>72,'mobile'=>48,'weight'=>500,'lh'=>0.98,'ls'=>-4]),
    vt_row([vt_btn('Neem contact op','#contact','',['pad'=>[17,28],'radius'=>8,'size'=>16]),vt_btn('Onze diensten in één oogopslag','#services','vt-btn-ghost',['bg'=>'transparent','fg'=>'#FFFFFF','hbg'=>'transparent','hfg'=>$SKY,'radius'=>8,'pad'=>[16,28],'size'=>16,'border'=>'rgba(255,255,255,0.4)'])],'',12,true,false)],
    'vt-hero-copy',['flex_gap'=>vt_gap(28),'width'=>vt_u('px',980),'width_tablet'=>vt_u('%',100)]);
  $out[]=vt_con([$copy],'vt-hero',['_element_id'=>'top','html_tag'=>'section','content_width'=>'boxed','boxed_width'=>vt_px(1440),'padding'=>vt_box(190,40,120,40),'padding_tablet'=>vt_box(190,40,96,40),'padding_mobile'=>vt_box(150,20,72,20),'flex_justify_content'=>'flex-end','flex_gap'=>vt_gap(72),'min_height'=>vt_u('vh',100),'min_height_mobile'=>vt_u('vh',90),'background_background'=>'video','background_video_link'=>'https://videos.pexels.com/video-files/1085656/1085656-hd_1280_720_25fps.mp4','background_video_fallback'=>vt_img('hero_poster'),'background_play_on_mobile'=>'yes','background_color'=>'#050B18']);
  // 2 marquee
  $F=[['Data&shy;netwerken','fas fa-server'],['Glasvezelnetwerken','fas fa-stream'],['Wifi-accesspoints','fas fa-wifi'],['Patchkasten','fas fa-ethernet'],['Kabelgoten','fas fa-grip-lines'],['Draadloze netwerken','fas fa-broadcast-tower'],['Camera&shy;beveiliging','fas fa-video']];
  $out[]=vt_con([vt_ilist($F,'vt-marquee',$NAVY,$BLUE)],'vt-marquee-wrap',['html_tag'=>'section','padding'=>vt_box(22,0),'background_background'=>'classic','background_color'=>'#F4F7FB','border_border'=>'solid','border_width'=>vt_box(0,0,1,0),'border_color'=>'#E1E7EF']);
  // 3 who
  $W=[['fas fa-server','01','Wij zijn een betrokken en vakkundige installateur, gespecialiseerd in de aanleg, optimalisatie en het onderhoud van gestructureerde datanetwerken.'],
    ['fas fa-user-check','02','Wat ons onderscheidt, is niet alleen onze technische expertise maar ook onze persoonlijke aanpak. Wij denken met u mee en leveren oplossingen waar u op kunt bouwen — van glasvezelnetwerken tot wifi-accesspoints, van patchkasten tot kabelgoten.'],
    ['fas fa-star','03','vtHullenaar BV is ontstaan uit passie voor het vak en voor betrouwbaarheid. Wat begon als eenmanszaak, is uitgegroeid tot een solide BV met een duidelijke missie: klanten voorzien van hoogwaardige, stabiele en professionele netwerk&shy;oplossingen.']];
  $wt=[];foreach($W as $x)$wt[]=vt_con([vt_icon($x[0],'vt-tab__icon',['size'=>20,'pad'=>16]),vt_con([vt_h($x[1],'div','#9AA8B9','vt-tab__num',['size'=>13,'weight'=>700,'ls'=>1.3]),vt_t('<p>'.$x[2].'</p>',$TEXT,'',['size'=>16,'lh'=>1.65])],'',['flex_gap'=>vt_gap(8),'_flex_size'=>'grow'])],'vt-tab',['flex_direction'=>'row','flex_gap'=>vt_gap(20),'padding'=>vt_box(24,22),'flex_align_items'=>'flex-start','border_radius'=>vt_box(18)]);
  $whoTabs=vt_con($wt,'vt-tabs',array_merge(['flex_gap'=>vt_gap(8)],vt_pct(50)));
  $stage=vt_con([vt_image('who1','vt-pane'),vt_image('who2','vt-pane'),vt_image('who3','vt-pane'),
    vt_con([vt_icon('fas fa-map-marker-alt','vt-ring',['size'=>18,'pad'=>12]),vt_t('<p><strong>vtHullenaar BV</strong><br>Zernikelaan 47, 2871 LP Schoonhoven</p>',$TEXT,'',['size'=>13,'lh'=>1.4])],'vt-glass vt-float-a vt-stage__top',['flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(12),'padding'=>vt_box(12,16,12,12)]),
    vt_con([vt_con([vt_h('Werkzaamheden vtHullenaar','div','#8FD0FF','vt-dot',['size'=>12,'weight'=>600,'ls'=>1.4,'transform'=>'uppercase']),vt_h('COMPLETE ONTZORGING VAN PATCHPANEEL TOT WERKPLEK!','div','#FFFFFF','',['size'=>15,'weight'=>600,'lh'=>1.35])],'vt-glass vt-glass--dark vt-float-b',['flex_gap'=>vt_gap(6),'padding'=>vt_box(18,20),'width'=>vt_u('px',300),'width_mobile'=>vt_u('%',100)]),
      vt_btn('Neem contact op →','#contact','vt-shadow-btn',['bg'=>$BLUE,'fg'=>'#FFFFFF','hfg'=>$NAVY,'pad'=>[13,22],'size'=>14])],'vt-stage__bottom',['flex_direction'=>'row','flex_wrap'=>'wrap','flex_justify_content'=>'space-between','flex_align_items'=>'flex-end','flex_gap'=>vt_gap(14)])],
    'vt-stage vt-stage--who',array_merge(vt_pct(50),['_flex_order_mobile'=>'start']));
  $out[]=vt_section([vt_con([vt_pill('Wie wij zijn'),vt_h('Alles wat wij doen draait om <strong>verbinding</strong> — letterlijk en figuurlijk.','h2',$NAVY,'vt-h2',['size'=>60,'tablet'=>44,'mobile'=>36,'weight'=>400,'lh'=>1.12,'ls'=>-1.8])],'',['flex_gap'=>vt_gap(22),'width'=>vt_u('px',680),'width_tablet'=>vt_u('%',100)]),
    vt_row([$whoTabs,$stage],'vt-switch',40,false)],'vt-who','who',['flex_gap'=>vt_gap(56)],'#FFFFFF');
  // 4 what
  $photos=vt_con([vt_image('what1','vt-photo vt-float-a'),vt_image('what2','vt-photo vt-photo--offset vt-float-b')],'vt-photo-pair',array_merge(['flex_direction'=>'row','flex_gap'=>vt_gap(18),'flex_align_items'=>'flex-start','width_tablet'=>vt_u('px',560)],vt_pct(48)));
  $grad=vt_con([vt_icon('fas fa-check','vt-ring-outline',['view'=>'framed','size'=>18,'pad'=>12]),vt_h('Alles aangelegd volgens de geldende normen, overzichtelijk gecodeerd, getest en operationeel opgeleverd.','div','#FFFFFF','',['size'=>15,'weight'=>600,'lh'=>1.45])],'vt-grad-card',array_merge(['flex_gap'=>vt_gap(16),'padding'=>vt_box(24),'border_radius'=>vt_box(20),'background_background'=>'gradient','background_color'=>$SKY,'background_color_stop'=>vt_u('%',0),'background_color_b'=>'#123A6E','background_color_b_stop'=>vt_u('%',100),'background_gradient_angle'=>vt_u('deg',150),'width_tablet'=>vt_u('%',100)],vt_pct(46)));
  $wcopy=vt_con([vt_h('Wat wij doen','div','#8FD0FF','vt-caret',['size'=>13,'weight'=>600,'ls'=>1,'transform'=>'uppercase']),
    vt_h('Betrouwbare en professionele netwerk&shy;oplossingen','h2','#FFFFFF','',['size'=>62,'tablet'=>44,'mobile'=>36,'weight'=>600,'lh'=>1.05,'ls'=>-2]),
    vt_row([$grad,vt_con([vt_h('Kiezen voor ons is kiezen voor kwaliteit, duidelijkheid en service waar u op kunt rekenen.','div','#FFFFFF','',['size'=>16,'weight'=>600,'lh'=>1.4]),vt_t('<p>Wij leveren betrouwbare en professionele netwerk&shy;oplossingen, van ontwerp tot oplevering. Of het nu gaat om een volledig nieuw netwerk, het uitbreiden van bestaande infrastructuur of het verhelpen van storingen — wij regelen het.</p>',$MUTED,'',['size'=>15,'lh'=>1.65]),(function($b){$b['settings']['_flex_align_self_mobile']='center';$b['settings']['align_mobile']='center';$b['settings']['_flex_align_self_tablet']='center';$b['settings']['align_tablet']='center';return $b;})(vt_btn('Neem contact op','#contact','',['bg'=>'transparent','fg'=>'#FFFFFF','hbg'=>'#FFFFFF','hfg'=>$NAVY,'pad'=>[12,22],'size'=>14,'border'=>'rgba(255,255,255,0.45)']))],'',array_merge(['flex_gap'=>vt_gap(14),'flex_align_items'=>'flex-start','width_tablet'=>vt_u('%',100)],vt_pct(50)))],'',24,false,true,['align'=>'flex-start','flex_direction_tablet'=>'column','flex_align_items_tablet'=>'stretch']),
    vt_t('<p>Wij werken voor allerlei bedrijven in elke denkbare sector en leveren maatwerk met oog voor kwaliteit en detail, waarbij technische precisie samengaat met een praktische aanpak.</p>',$MUTED,'',['size'=>15,'lh'=>1.65])],'',array_merge(['flex_gap'=>vt_gap(26),'width_tablet'=>vt_u('%',100)],vt_pct(52)));
  $bottom=vt_con([vt_h('Precies zoals het hoort!','div','#FFFFFF','vt-divider-badge',['size'=>13,'weight'=>600],['align'=>'center']),vt_ilist([['Data&shy;netwerken','fas fa-ethernet'],['Draadloze netwerken','fas fa-broadcast-tower'],['Camera&shy;beveiliging','fas fa-video'],['Glasvezelnetwerken','fas fa-stream'],['Kabelgoten','fas fa-grip-lines']],'vt-feature-row','#C9D6E6',$SKY,17,600)],'vt-what-bottom',['flex_gap'=>vt_gap(36),'padding'=>vt_box(72,0,0,0)]);
  $out[]=vt_section([vt_row([$photos,$wcopy],'',48,false,true,['flex_direction_tablet'=>'column','flex_align_items_tablet'=>'stretch']),$bottom],'vt-dark vt-waves','what',[],null,[130,40,110,40]);
  // 5 services
  $panes=[];$rows=[];
  foreach($SV as [$n,$label,$title,$key,$ic,$body]){
    $panes[]=vt_con([vt_con([vt_h($label,'div','#FFFFFF','vt-chip vt-dot',['size'=>12,'weight'=>600]),vt_h($n,'div','#FFFFFF','vt-outline-num',['size'=>64,'weight'=>700,'lh'=>1])],'vt-pane__top',['flex_direction'=>'row','flex_justify_content'=>'space-between','flex_align_items'=>'center']),
      vt_con([vt_con([vt_icon($ic,'vt-square-icon',['color'=>$BLUE,'bg'=>'#FFFFFF','size'=>22,'pad'=>12]),vt_h($title,'h3','#FFFFFF','',['size'=>36,'tablet'=>28,'mobile'=>26,'weight'=>700,'lh'=>1.05,'ls'=>-1])],'',['flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(14)]),vt_t('<p>'.$body.'</p>','#E2EAF4','',['size'=>15,'lh'=>1.6])],'vt-glass vt-glass--light',['flex_gap'=>vt_gap(12),'padding'=>vt_box(26,26,28,26)])],
      'vt-pane vt-svc-pane',['flex_justify_content'=>'space-between','padding'=>vt_box(44,22,18,22),'background_background'=>'classic','background_image'=>vt_img($key),'background_position'=>'center center','background_size'=>'cover','background_repeat'=>'no-repeat']);
    $rows[]=vt_con([vt_icon($ic,'vt-tab__icon vt-tab__icon--square',['bg'=>'#F1F4F9','color'=>$NAVY,'size'=>20,'pad'=>14]),vt_con([vt_h($title,'div',$NAVY,'',['size'=>19,'weight'=>700,'ls'=>-0.4]),vt_h($label,'div','#6B7A8F','',['size'=>13,'weight'=>400])],'',['flex_gap'=>vt_gap(3),'_flex_size'=>'grow']),vt_h($n,'div','#9AA8B9','vt-tab__badge',['size'=>15,'weight'=>400])],'vt-tab vt-tab--row',['flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(16),'padding'=>vt_box(16,18),'border_radius'=>vt_box(20)]);
  }
  $sstage=vt_con($panes,'vt-stage vt-stage--svc',array_merge(['min_height'=>vt_px(600)],vt_pct(50)));
  $sside=vt_con([vt_con([vt_pill('Diensten'),vt_h('Onze diensten <strong>in één oogopslag</strong>','h2',$NAVY,'vt-h2',['size'=>60,'tablet'=>44,'mobile'=>36,'weight'=>400,'lh'=>1.08,'ls'=>-2])],'',['flex_gap'=>vt_gap(22)]),vt_con($rows,'vt-tabs',['flex_gap'=>vt_gap(10)]),
    vt_btn('Neem contact op','#contact','vt-btn-arrow',['bg'=>$NAVY,'fg'=>'#FFFFFF','hbg'=>$BLUE,'hfg'=>'#FFFFFF','pad'=>[8,8],'icon'=>'fas fa-arrow-right'])],'',array_merge(['flex_gap'=>vt_gap(28),'flex_justify_content'=>'space-between'],vt_pct(50)));
  $out[]=vt_section([vt_row([$sstage,$sside],'vt-switch',40,false,true,['align'=>'stretch'])],'vt-services vt-glow','services',[],'#FFFFFF');
  // 6 projects
  $cols=[['prj1','prj2','prj3'],['prj4','prj5','prj6'],['prj7','prj8','prj1']];$dirs=['up','down','up2'];$cc=[];
  foreach($cols as $i=>$c){$imgs=[];foreach($c as $k)$imgs[]=vt_image($k,'vt-tile',[],true,'medium_large');$cc[]=vt_con($imgs,'vt-col vt-col--'.$dirs[$i],['flex_gap'=>vt_gap(16)]);}
  $wall=vt_con($cc,'vt-wall',array_merge(['flex_direction'=>'row','flex_gap'=>vt_gap(16)],vt_pct(55)));
  $pcopy=vt_con([vt_pill('Projecten',true),vt_h('Onze <strong>projecten</strong>','h2','#FFFFFF','',['size'=>72,'tablet'=>52,'mobile'=>40,'weight'=>400,'lh'=>1.02,'ls'=>-3]),
    vt_row([vt_h('08','div',$SKY,'vt-outline-num vt-outline-num--sky',['size'=>104,'mobile'=>64,'weight'=>700,'lh'=>0.9,'ls'=>-5]),vt_t('<p>projecten in<br>de galerij</p>',$MUTED,'',['size'=>15,'lh'=>1.4])],'',14,true,false,['align'=>'flex-end']),
    vt_btn('Bekijk projecten','PAGE:projects','vt-btn-arrow vt-btn-arrow--light',['bg'=>'#FFFFFF','fg'=>$NAVY,'hbg'=>$SKY,'hfg'=>'#FFFFFF','pad'=>[8,8],'icon'=>'fas fa-th-large']),
    vt_con([vt_h('Uw project <strong>hier?</strong>','div','#FFFFFF','',['size'=>22,'weight'=>400,'ls'=>-0.4]),vt_h('Neem contact op →','div',$SKY,'',['size'=>14,'weight'=>600])],'vt-glass vt-glass--card',['html_tag'=>'a','link'=>vt_link('#contact'),'flex_gap'=>vt_gap(4),'padding'=>vt_box(22,24),'width'=>vt_u('px',420),'width_mobile'=>vt_u('%',100)])],
    '',array_merge(['flex_gap'=>vt_gap(28),'flex_align_items'=>'flex-start','padding'=>vt_box(120,0),'padding_mobile'=>vt_box(40,0)],vt_pct(45)));
  $out[]=vt_section([vt_row([$pcopy,$wall],'',48,false)],'vt-dark vt-dark--projects vt-blob','projects',[],null,[0,40,0,40]);
  // 7 testimonials
  $Q=[['"vtHullenaar heeft ons volledig ontzorgd bij de aanleg van ons nieuwe datanetwerk. Van advies tot oplevering — alles perfect geregeld en volgens de normen aangelegd."','— Klant'],
    ['"Professioneel, betrokken en vakkundig. Ze denken met je mee en leveren kwaliteit waar je op kunt bouwen. Precies wat je zoekt in een partner voor je bedrijfsnetwerk."','— Klant van vtHullenaar']];
  $cards=[];foreach($Q as $i=>[$q,$a])$cards[]=vt_con([vt_row([vt_h('★★★★★','div',$SKY,'',['size'=>18]),vt_h('0'.($i+1),'div','currentColor','vt-tcard__n',['size'=>13,'weight'=>600,'ls'=>1])],'',16,true,false,['flex_justify_content'=>'space-between']),
    vt_t('<p>'.$q.'</p>','inherit','vt-tcard__quote',['size'=>28,'tablet'=>22,'mobile'=>20,'weight'=>500,'lh'=>1.4,'ls'=>-0.5]),
    vt_row([vt_h('v','div','#FFFFFF','vt-avatar',['size'=>18,'weight'=>700],['align'=>'center']),vt_h($a,'div','inherit','',['size'=>16,'weight'=>600])],'',14,true,false)],
    'vt-pane vt-tcard',['flex_justify_content'=>'space-between','flex_gap'=>vt_gap(28),'padding'=>vt_box(52),'padding_mobile'=>vt_box(32),'border_radius'=>vt_box(32)]);
  $tleft=vt_con([vt_pill('Ervaringen'),vt_h('Wat klanten <strong>zeggen</strong>','h2',$NAVY,'vt-h2',['size'=>72,'tablet'=>52,'mobile'=>40,'weight'=>400,'lh'=>1.02,'ls'=>-3]),
    vt_row([vt_btn('←','#','vt-prev vt-round',['bg'=>'#FFFFFF','fg'=>$NAVY,'hbg'=>'#FFFFFF','hfg'=>$NAVY,'pad'=>[16,20],'size'=>18,'border'=>'#D5DEE9']),vt_btn('→','#','vt-next vt-round',['bg'=>$NAVY,'fg'=>'#FFFFFF','hbg'=>$BLUE,'hfg'=>'#FFFFFF','pad'=>[16,20],'size'=>18]),vt_h('01 / 02','div',$NAVY,'vt-counter',['size'=>14,'weight'=>600,'ls'=>0.6])],'vt-t-controls',20,true,false)],
    '',array_merge(['flex_gap'=>vt_gap(26)],vt_pct(45)));
  $out[]=vt_section([vt_row([$tleft,vt_con($cards,'vt-stage vt-stage--cards',array_merge(['min_height'=>vt_px(460)],vt_pct(55)))],'vt-switch vt-switch--cards',56,false)],'vt-glow vt-glow--bottom','',[],'#FFFFFF');
  // 8 contact
  $crow=function($ic,$label,$value,$url=null)use($NAVY,$TEXT){return vt_con([vt_icon($ic,'',['size'=>18,'pad'=>15]),vt_con([vt_h($label,'div',$TEXT,'',['size'=>13,'weight'=>400]),vt_h($value,'div',$NAVY,'',['size'=>20,'weight'=>600],$url?['link'=>vt_link($url)]:[])],'',['flex_gap'=>vt_gap(2)])],'vt-contact-row',['flex_direction'=>'row','flex_align_items'=>'center','flex_gap'=>vt_gap(18),'padding'=>vt_box(22,0)]);};
  $card=vt_row([vt_con([vt_pill('Contact'),vt_h('Complete ontzorging van <strong>patchkast tot werkplek</strong>','h2',$NAVY,'vt-h2',['size'=>60,'tablet'=>44,'mobile'=>36,'weight'=>400,'lh'=>1.12,'ls'=>-1.8]),vt_btn('Mail ons','mailto:info@vthullenaar.nl','',['bg'=>$BLUE,'fg'=>'#FFFFFF','hbg'=>$NAVY,'hfg'=>'#FFFFFF'])],'',array_merge(['flex_gap'=>vt_gap(22),'flex_align_items'=>'flex-start'],vt_pct(50))),
    vt_con([$crow('fas fa-phone-alt','Telefoon','(0031) 182 700 616','tel:0031182700616'),$crow('fas fa-envelope','E-mail','info@vthullenaar.nl','mailto:info@vthullenaar.nl'),$crow('fas fa-map-marker-alt','Adres','Zernikelaan 47, 2871 LP Schoonhoven')],'',vt_pct(50))],
    'vt-contact-card',56,false,true,['content_width'=>'boxed','boxed_width'=>vt_px(1280),'padding'=>vt_box(72),'padding_mobile'=>vt_box(36,24),'background_background'=>'classic','background_color'=>'#FFFFFF','border_border'=>'solid','border_width'=>vt_box(1),'border_color'=>'#E1E7EF','border_radius'=>vt_box(28)]);
  $out[]=vt_con([$card],'vt-contact',['_element_id'=>'contact','html_tag'=>'section','padding'=>vt_box(120,20),'padding_mobile'=>vt_box(72,16),'background_background'=>'classic','background_color'=>'#F4F7FB']);
  return $out;
}
function vt_inner($title,$crumb,$intro=null){
  $k=[vt_t('<p><a href="PAGE:home">Home</a><span>/</span><span class="is-current">'.$crumb.'</span></p>','#AFC0D4','vt-crumb',['size'=>14]),vt_h($title,'h1','#FFFFFF','vt-page-title',['size'=>92,'tablet'=>64,'mobile'=>44,'weight'=>400,'lh'=>1,'ls'=>-4])];
  if($intro)$k[]=vt_t('<p>'.$intro.'</p>','#C6D2E0','',['size'=>18,'lh'=>1.6]);
  return [vt_section($k,'vt-dark vt-waves vt-page-header','',['flex_gap'=>vt_gap(22)],null,[200,40,150,40])];
}
$data=['header'=>vt_header(),'footer'=>vt_footer(),'home'=>vt_home(),
  'services'=>vt_inner('Our services <strong>at a glance</strong>','Services','Complete care from patch panel to workspace.'),
  'projects'=>vt_inner('Our <strong>projects</strong>','Projects'),
  'about'=>vt_inner('Who we are','About us','Everything we do revolves around connection — literally and figuratively.'),
  'contact'=>vt_inner('Get in touch','Contact'),'terms'=>vt_inner('Terms &amp; conditions','Terms')];
