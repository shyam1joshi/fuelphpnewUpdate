                                     
   <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
            
        
        <?php echo Asset::css('bootstrap.min.css');
                ?>
                   
                <?php
        
            #echo Asset::css('jquery-ui-1.8.20.custom.css');
            echo Asset::css('minified/jquery-ui.min.css');
            echo Asset::css('chosen.min.css');
            echo Asset::css('select/select2.css'); 
        ?> 
                
        <?php // echo \Asset::css('formbuilder/formbuilder.css'); ?> 
        <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/assets/css/checkbox-x.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.snow.min.css">
                 
   <link rel="stylesheet" href="/dynamicformssystem/basesystem/formcss">
                <link rel="stylesheet" href="/dynamicformssystem/basesystem/newformcss">
                <link rel="stylesheet" href="/dynamicformssystem/basesystem/formcsstwo">
                <link rel="stylesheet" href="/dynamicformssystem/basesystem/formbuildercss">
                <link rel="stylesheet" href="/dynamicformssystem/basesystem/responsive">
                <!-- <link rel="stylesheet" href="/dynamicformssystem/basesystem/sectioncss"> -->
                <link rel="stylesheet" href="/dynamicformssystem/basesystem/formcssresponsive">



<br/><br/>

<div class='row-fluid show-grid text-center'>
    <h2>אופן שליחת הקישור</h2>
    <?php if(isset($hide_link_expire_date) && $hide_link_expire_date == '1'){}else{ ?>
    <!-- <div class="text-center row g-3 d-lg-inline-flex"> -->
  <div class="col-12  text-center " style="display: inline-flex;">  
    <label class='span8' >תאריך תוקף לקישור(לא חובה):<sub><img  style="    width: 34px;
    height: 34px;"
    data-bs-toggle="tooltip" data-bs-placement="top" title="תאריך תוקף לקישור מאפשר להגביל את התוקף של
ההצעה\החוזה שהקישור מכיל, במידה ויפתחו את הקישור לאחר שהתוקף יסתיים
הקישור לא יפתח." src="/assets/img/QM.png"></sub>
        </label>
        <input type="date" class="span5 save_link_expire_date"  onkeydown="return false"  url-link="/<?php echo $urllink ?>" name="link_expire_date" value="<?php if(is_object($object) && isset($object->link_expire_date )) echo $object->link_expire_date ?>" min="<?php echo date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d')))) ?>" >

  </div>
  <!-- <div class="col-12 col-lg-auto text-center"> 
     </div> -->
  <!-- <div class="col-12 col-lg-auto"> -->
  <!-- <button id="save_link_expire_date" class="btn btn-primary mb-3"  url-link="/<?php echo $urllink ?>">Save</button> -->
  <input type="hidden" value="<?php echo $id ?>" name="id"/>
  <!-- </div> -->
<!-- </div> -->
<br/>
<br/>
<?php } ?>

    <div class='text-center' >להלן הקישור:</div>
    <br/>   
    <div class='span12'>
<?php   if(!empty($newurl)){ ?>
<div class='span2' style="margin-left: 14px !important;" >
</div>
<div class='span8'style="    margin-left: 0px !important;">
    <div class="input-group mb-3">
    <input type="text" class="form-control urllink" value="<?php echo $newurl ?>" readonly style=" direction:rtl;text-align:right;  border-radius: 0px 20px 20px 0px;" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
    <div class="input-group-append">
        <button class=" " type="button"  id="clickcopyclip" data-clipboard-text="<?php echo $newurl ?>" style="  color:#fff; border:#8bc53f; border-radius: 20px 0px 0px 20px;background-image:linear-gradient(to bottom,#8bc53f,#8bc53f);"><i class="icon-link"></i> העתק</button>
    </div>
    <textarea id="copyURL" style="opacity: 0;height:2px;"><?php echo $newurl ?></textarea>
    </div>
    
</div>
 

    <div class='span12 text-center textalign' style="    margin-left: 0px !important;   margin-bottom: 20px !important;">ניתן לשלוח את הקישור בכל אחת מהדרכים הבאות, יש ללחוץ על הכפתור כדי לבחור את הדרך הנוחה לכם:</div>
    <br/>
    <br/>

    <div class="span2  ">
    </div>
    <div class="span8 row sendbtnlist ">
        <div class="span4 text-right popup idpopup1" idfrom="myPopup1"  >
            <a class="  emailsms" id="whatsapp-click" type="whatsapp" custname="<?php if(isset($custname)) echo $custname ?>" onclick="myFunction(this)" mobile="<?php if(isset($whatsapp_mobile_number)) {
            
      //      if(isset($whatsapp_mobile_number) && count($whatsapp_mobile_number) > 7)
            
            echo $whatsapp_mobile_number ; } ?>"  hrefxxx="whatsapp://send?phone=" 
                text="קיבלתם טופס לחתימה דיגיטלית מאתר צימר. קראו בעיון וחתמו. תודה ובהצלחה. <?php echo $newurl ?>" >
                <img src="/assets/img/whatsapp.svg"></a>
                <br/>
                <label> WhatsApp   <br/>  נא להזין מספר </label>  &nbsp; &nbsp;

                <div class="popuptext" id="myPopup1"  >
                    <form method="post" class="" id="emailSMSForm1" style=" padding: 10px 30px;" action="#">
                        <div class=" showWhatsapp" style="text-align:center;">
                            <strong class=" ">יש להקליד את מספר הנייד</strong><br><br/>
                            <div style="display:inline-flex">
                                <input type="tel" class=" whatsapp_mobile_number span8"  pattern="[0-9]+(\.[0-9][0-9]?)?" value="<?php if(isset($whatsapp_mobile_number)  ) echo $whatsapp_mobile_number; ?>" placeholder="מספר טלפון" name="whatsapp_mobile_number">
                                &nbsp;<b>-</b> &nbsp;
                                <select class=" span2 phoneNumberCodeBox whatsapp_mobile_number_code"  id="phonenumber_1643969552977" name="whatsapp_phonecode"> 
                                    <option value="" style="opacity: 0.5;">קידומת</option>
                                    <option value="050" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "050") echo 'selected' ?>> 050</option>
                                    <option value="051" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "051") echo 'selected' ?>>051</option>
                                    <option value="052" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "052") echo 'selected' ?>>052</option>
                                    <option value="053" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "053") echo 'selected' ?>>053</option>
                                    <option value="054" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "054") echo 'selected' ?>>054</option>
                                    <option value="055" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "055") echo 'selected' ?>>055</option>
                                    <option value="056" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "056") echo 'selected' ?>>056</option>
                                    <option value="058" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "058") echo 'selected' ?>>058</option>
                                    <option value="059" <?php if(isset($whatsapp_mobile_number_code) && $whatsapp_mobile_number_code == "059") echo 'selected' ?>>059</option>
                                </select> 
                            </div> 
                        </div> 
                        <div class="" style="text-align:center"> 
                            <a class="btn btn-primary showWhatsapp share"   text="קיבלתם טופס לחתימה דיגיטלית מאתר צימר. קראו בעיון וחתמו. תודה ובהצלחה. <?php echo $newurl ?>" attr-href="https://api.whatsapp.com/send/">שילחו לי קישור</a>
                        </div>
                    </form>   
                </div>
            </div>
            <?php  if(1){ ?>
            <div class="span4 text-right popup idpopupmargin "  idfrom="myPopup4">
            <a href="whatsapp://send?text=שלום, נשלח לך קישור לצפייה וחתימה מ <?php if(isset($custname)) echo $custname ?>:<?php echo $newurl ?>">
                <img src="/assets/img/whatsapp.svg" />
                <br/>
                <label> WhatsApp   <br/> אנשי קשר</label>  &nbsp; &nbsp;
            </a>
            </div>
        <?php }?>

                <?php  if(isset($enablesms) && $enablesms == 1 ){ ?>
            <div class="span4 text-center popup idpopup2"  idfrom="myPopup2">
                <a class="  emailsms" id="emailsms" onclick="myFunction(this)" mobile="<?php if(isset($sms_mobile_number)) echo $sms_mobile_number ?>" type="sms" url="/<?php echo $base; ?>/sendLinkSMS/<?php echo $id; ?>"  >   
                <img src="/assets/img/sms.svg"></a> <br/><label class=" text-center" > SMS</label>    &nbsp; &nbsp;
                
                <div class="popuptext" id="myPopup2"  >
                    <form method="post" class="" id="emailSMSForm2" style=" padding: 10px 30px;" action="/<?php echo $base; ?>/sendLinkSMS/<?php echo $id; ?>">
                        <div class=" showWhatsapp" style="text-align:center;">
                            <strong class=" ">יש להקליד את מספר הנייד</strong><br><br/>
                            <div style="display:inline-flex">
                                <input type="tel" class=" mobile_number span8"  pattern="[0-9]+(\.[0-9][0-9]?)?"  value="<?php if(isset($sms_mobile_number)  ) echo $sms_mobile_number; ?>" placeholder="מספר טלפון" id="whatsapp_mobile_number_id" name="mobile_number">
                                &nbsp;<b>-</b> &nbsp;
                                <select class=" span2 phoneNumberCodeBox mobile_number_code"  id="phonenumber_1643969552977" name="phonecode"> 
                                    <option style="opacity: 0.5;">קידומת</option>
                                    
                                    <option value="050" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "050") echo 'selected' ?>> 050</option>
                                    <option value="051" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "051") echo 'selected' ?>>051</option>
                                    <option value="052" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "052") echo 'selected' ?>>052</option>
                                    <option value="053" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "053") echo 'selected' ?>>053</option>
                                    <option value="054" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "054") echo 'selected' ?>>054</option>
                                    <option value="055" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "055") echo 'selected' ?>>055</option>
                                    <option value="056" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "056") echo 'selected' ?>>056</option>
                                    <option value="058" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "058") echo 'selected' ?>>058</option>
                                    <option value="059" <?php if(isset($sms_mobile_number_code) && $sms_mobile_number_code == "059") echo 'selected' ?>>059</option>
                                </select> 
                            </div> 
                        </div> 
                        <div class="" style="text-align:center"> 
                        <input type="submit" class="btn btn-primary submit showWhatsappsubmit" value="שילחו לי קישור"/> 
                        </div>
                    </form>   
                </div>
            </div>
            <?php }?>
            <div class="span4 text-left popup"  idfrom="myPopup3">
                <a class="  emailsms" id="whatsapp-clickx"  onclick="myFunction(this)" email="<?php if(isset($email)) echo $email ?>" type="email" url="/<?php echo $base; ?>/sendLinkEmail/<?php echo $id; ?>"   >
                <img src="/assets/img/email.svg"></a> 
                <br/>
                <label class="  text-left" > Email</label>    &nbsp; &nbsp;
                
                <div class="popuptext" id="myPopup3"  >
                    <form method="post" class="" id="emailSMSForm3" style=" padding: 10px 30px;" action="/<?php echo $base; ?>/sendLinkEmail/<?php echo $id; ?>">
                        <div class=" showWhatsapp" style="text-align:center;">
                            <strong class=" ">יש להקליד כתובת אימייל</strong><br><br/>
                            <div style="display:inline-flex">
                                
                            <input  type="email" class=" span12"  name="email"  />
                            </div> 
                        </div> 
                        <div class="" style="text-align:center"> 
                        <input type="submit" class="btn btn-primary submit showWhatsappsubmit" value="שלח קישור ללקוח"/> 
                        </div>
                    </form>   
                </div>
            </div>
        </div>

        <div class="span2  ">
        </div>

    </div>
</div>
                
            <?php }else{ ?>
            <?php if(isset($flow) && $flow == 1){ ?>
                <a href="/<?php echo $base; ?>/tryagain/<?php echo $id ?>" class="btn btn-primary" > Try Again... </a>
                <?php }else{ ?>
                
                <?php } ?>
            <?php } ?>
 

<style>

.popup .popuptext{
        background:#fff !important;
        width: 332px !important;
        color:#000 !important;
        box-shadow: 0px 0px 30px #00000029 !important;
        border: 1px solid #E5E5E5 !important;    
        border-radius: 37px !important; 
    }

    .popup{
        margin-left: 0px !important;
    }

    .whatsapp_mobile_number,.mobile_number{
        background: #FFFFFF 0% 0% no-repeat padding-box;
        border: 1px solid #E5E5E5;
        border-radius: 20px !important;
    }

    .whatsapp_mobile_number_code,.mobile_number_code{
        background: #FFFFFF 0% 0% no-repeat padding-box;
border: 1px solid #E5E5E5;
border-radius: 20px;
    }

    input[name="email"]{
        
    border-radius: 20px !important;
    }

    a.showWhatsapp,.showWhatsappsubmit{
        background: #27C34B 0% 0% no-repeat padding-box;
        border: 1px solid #27C34B;
        border-radius: 20px;
        opacity: 1;

    }

    .input-group {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 100%;
}
.input-group>.form-control {
    position: relative;
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    width: 1%;
    margin-bottom: 0;
    width: 50%;
    margin-bottom: 0;
    height: 32px;
    
}.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.input-group-append {
    margin-left: -1px;
}

.input-group-append, .input-group-prepend {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.input-group-append .btn, .input-group-prepend .btn {
    position: relative;
    z-index: 2;
}


/** */

/* Popup container */
.popup {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

/* The actual popup (appears on top) */
.popup .popuptext {
  visibility: hidden;
  width: 160px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  z-index: 1;
  /* bottom: 125%; */
  left: 50%;
  margin-left: -80px;
}

/* Popup arrow */
.popup .popuptext::before {
  /* content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 8px;
  border-style: solid;
  border-color: #fff transparent transparent transparent; */

  position: absolute;
    top: -9px;
    right: 205px;
    display: inline-block;
    border-left: 9px solid transparent;
    border-bottom: 9px solid #ccc;
    border-right: 9px solid transparent;
    border-bottom-color: rgb(255 255 255);
    content: '';
}

/* Toggle this class when clicking on the popup container (hide and show the popup) */
.popup .show {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}



@media only screen and (max-width: 619px)   {

    #myPopup1{
        right: -36px;
        right: -17px;
    }
    #myPopup3{ 
        right: -188px;
    }
    
    #myPopup2{
        right: -30px;
    }
    .span12.textalign{
        margin-right: 53px !important;
        /* width: 326px; */
        width: auto;
    } 
}

@media only screen and (max-width: 420px) and (min-width: 370px){
body.background-image div.row-fluid.show-grid.text-center {
    margin-right: -15px !important;
    width: 103% !important;
    margin-left: 0;
}
    .row.sendbtnlist{
        display: grid; 
     margin-right: 152px !important;
    }

    .popup.idpopup1{
            margin-right: 20px !important;
    }
    .popup.idpopupmargin{
            margin-right: 20px !important;
    }
    .popup.idpopup2{
            margin-right: 10px !important;
    }
    #myPopup1 { 
    right: -179px;
}#myPopup2 {
    right: -164px;
}
#myPopup3 {
    right: -140px;
}
}

@media only screen and (max-width: 370px) and (min-width: 344px){
body.background-image div.row-fluid.show-grid.text-center  {
    margin-right: -35px !important;
    width: 106% !important;
    margin-left: 0;
}

.row.sendbtnlist{
        display: grid; 
     margin-right: 152px !important;
    }

    .popup.idpopup1{
            margin-right: 20px !important;
    }
    #myPopup1 { 
    right: -102px;
}#myPopup2 {
    right: -92px;
}
#myPopup3 {
    right: -80px;
}
    .popup.idpopup2{
            margin-right: 10px !important;
    }
}


@media only screen and (min-width: 200px) and (max-width: 815px){
.span12 a.btn.share {
    display: initial !important;
}
}

</style>

<script>
// When the user clicks on <div>, open the popup
function myFunction(x) {
    var e =$(x).parent();
    var id = e.attr('idfrom');

    var mobile_number = e.find('.emailsms').attr('mobile');
    var mobile_number_code = e.find('.emailsms').attr('mobile_number_code');
    var email = e.find('.emailsms').attr('email');
    var type = e.find('.emailsms').attr('type');
    
    if(type == 'sms' || type == 'whatsapp'){
        e.find('input[type="number"]').val(mobile_number);
      //  e.find('select').children('option[value="'+mobile_number_code+'"]').attr('selected');
      mobile_number_code = e.find('select').val();
        var code =  mobile_number_code.substr(1,2);
        var custname = e.find('.emailsms').attr('custname');
        if(  type == 'whatsapp'){
            var href = 'https://wa.me/';
            
        var text = 'שלום, נשלח לך קישור לצפייה וחתימה מ'+custname+':'
        text += '%0A'+$('.urllink').val();
            // e.find('.showWhatsapp').attr('href', href+'?phone=&972'+code+mobile_number+'&text=שלום, נשלח לך קישור לצפייה וחתימה '+$('.urllink').val()+' מ '+custname); 
            e.find('.showWhatsapp').attr('href', href+'?phone=972'+code+mobile_number+'&text='+text); 
 }
    }else{
        e.find('input[type="email"]').val(email);
    }

    $('.popuptext').removeClass('show');
 
  //var popup = document.getElementById(id);
if(e.hasClass('show')){
    e.removeClass('show');
}else{
    e.addClass('show');
  e.find('.popuptext').addClass('show');
}
//   popup.classList.toggle("show");
}
</script>