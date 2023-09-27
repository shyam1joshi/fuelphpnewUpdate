<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <todo style="display:none"> Step 4, Sign document , write using bootstrap
        PDF document in the center , right side panel for toolbar ,
        from where the customer gets positions , where the annotations are
        where , sign area is clicked , if signature exists show choose signature, or
        Allow to choose more signatures ,
        If not open window to sign.

        Once all signs are complete move on to the next items of process
        and upload and then trigger download



  </todo>
  <meta charset="utf-8"/>
    <meta name="viewport" content="user-scalable=no">

  <title>Signhere</title>
  <link rel="stylesheet" type="text/css" href="/assets/js/pdfshared/toolbar.css"/>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="/assets/js/pdfshared/pdf_viewer.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
  <style type="text/css">

  @media only screen and (min-width: 901px) and (max-width: 950px) {
    .no-left a.col-5.clearSign{

              /* font-size:6vw!important; */
              height: fit-content;

      }

      div.goback {

            height: fit-content;
      }
     .no-left a.col-5.exportSign{

                height: fit-content;

        }
        f{
          font-size:5.5vw!important;
            top:40%;
        }
  }
    @media only screen and (min-width: 951px) and  (max-width: 990px) {
      .no-left a.col-5.clearSign{

                /* font-size:6vw!important; */
                /* height: 35%!important; */
                /* top:40%; */
                  height: fit-content;
        }
       .no-left a.col-5.exportSign{

                  /* height: 35%!important; */
                  /* top:40%; */
                    height: fit-content;
          }
          f{
            font-size:6vw!important;
              top:40%;
          }
          div.goback {

                height: fit-content;
          }
  }

  @media only screen and (min-width: 500px) and  (max-width: 900px){
    .no-left a.col-5.clearSign{

              /* font-size:5vw!important; */
                height: fit-content;
              /* top:40%; */
      }
     .no-left a.col-5.exportSign{

                height: fit-content;
                /* top:40%; */
        }
        f{
            font-size:5vw!important;
            top:40%;
        }
        div.goback {

              height: fit-content;
        }
}

.no-left a.col-5.clearSign{

        /* font-size:4vw; */
        height: fit-content;
}
f{
    font-size:5.5vw;
    top:40%;
}
div.goback {

      height: fit-content;
}
.no-left a.col-5.exportSign{


        /* font-size:4vw; */
        height: fit-content;
}
    .modal-dialog-full-width {
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width:none !important;

    }

    .modal-content-full-width  {
        height: auto !important;
        min-height: 70% !important;
        border-radius: 0 !important;
        background-color: #ececec !important
    }

    .modal-header-full-width  {
        border-bottom: 1px solid #9ea2a2 !important;
    }

    .modal-footer-full-width  {
        border-top: 1px solid #9ea2a2 !important;
    }
    body {
      background-color: #eee;
      font-family: sans-serif;
      margin: 0;
         overscroll-behavior:none;
    }

    .pdfViewer .canvasWrapper {
      box-shadow: 0 0 3px #bbb;
    }
    .pdfViewer .page {
      margin-bottom: 10px;
    }

    .annotationLayer {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }

    #content-wrapper {
      position: absolute;
      top: 70px;
      left: 0;
      /* //right: 250px; */
      bottom: 0;
      overflow: auto;
    }

    #comment-wrapper {
      position: absolute;
      top: 100px;
      right: 0;
      display:none;
      /* bottom: 0; */
      overflow: auto;
      width: 250px;
      background: #eaeaea;
      border-left: 1px solid #d0d0d0;
    }
    #comment-wrapper h4 {
      margin: 10px;
    }
    #comment-wrapper .comment-list {
      font-size: 12px;
      position: absolute;
      top: 38px;
      left: 0;
      right: 0;
      bottom: 0;
    }
    #comment-wrapper .comment-list-item {
      border-bottom: 1px solid #d0d0d0;
      padding: 10px;
    }
    #comment-wrapper .comment-list-container {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 47px;
      overflow: auto;
    }
    #comment-wrapper .comment-list-form {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      padding: 10px;
    }
    #comment-wrapper .comment-list-form input {
      padding: 5px;
      width: 100%;
    }
    .toolbar{
        height:100px;
    }
    .toolbar .btn{
      /* height:55px; */
      height:inherit;
      font-size: 4vw;
    }
    .toolbar a.btn{
      color:white;
    }
    .row a.btn{
      color:white;
       font-size: 26px;
      height:50px;
    }
    .no-left{

      margin-left: 0px;
      height:fit-content;
    }
    div.goback {

          height: fit-content;
    }

  buttonx.btn-large.btn.submitPreviewAndDownload.btn-info{
    background: url('/assets/img/andromeda/download_pdf.png');
    background-size:100% 100%

  }

  buttonx.btn.btn-large.submitForm
  {
      background: url('/assets/img/andromeda/submit_sign.png');
      background-size:100% 100%
  }

    a.clear.btn-large.btn.btn-dange{
        background: url('/assets/img/andromeda/1.png');
        background-size:100% 100%
    }

    /* .btn.btn-large.exportSign.col-5{
        background: url('https://andromeda.tofsy-il.com:4430/assets/img/andromeda/accept_sign.png');
        background-size:100% 100%
    } */
    /* .btn.btn-large.clearSign.col-5{
        background: url('https://andromeda.tofsy-il.com:4430/assets/img/andromeda/delete_sign.png');
        background-size:100% 100%
    }
    .btn.btn-large.goback.col-6{
        background: url('https://andromeda.tofsy-il.com:4430/assets/img/andromeda/go_back.png');
        background-size:100% 100%
    } */




  </style>

</head>
<body>
<div id="pdfWorkerSrc" style="display:none">/assets/js/pdfshared/pdf.worker.js</div>

 
<div id="docuName" 
     filename="/<?php
   if(isset($path) ){ 
            echo $path; 
    }
 
    ?>" value="/<?php
    if(isset($path) ){ 
             echo $path; 
     }
  
     ?>" style="display:none"></div>


<div id="content-wrapper" class="container-fluid" style="">

  <div id="viewer" class="pdfViewer mainPage"></div>
  <div class="col-12 text-center m-2 mb-5">

  <?php
 
$modulename_with_s = $modulename;
$lastchar = substr($modulename, -1);
if($lastchar == 's'){

}else{
    $modulename_with_s .= 's';
}
 $url = $modulename.'/'.$modulename_with_s; ?>

<a href="/<?php  echo $url; ?>/edit/<?php if(isset($object) && is_object($object)) echo $object->id ?>" class="btn  btn-bold btn-primary ">חזרה לעריכה</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="/<?php  echo $url; ?>/submitForm/<?php if(isset($object) && is_object($object)) echo $object->id ?>" class="btn  btn-bold  btn-success  " >אישור</a>
    </div>
</div>


  <script src="/assets/js/sign.js?id=<?php  echo \time();?>"></script>
 
</body>
</html>
