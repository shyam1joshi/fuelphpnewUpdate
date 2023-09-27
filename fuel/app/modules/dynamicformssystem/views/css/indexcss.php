<?php if(1==0) { ?>
<style>
    
<?php }  ?>


.span12  img{
             margin-left: 0 !important;
     }
    span.active > a{
        font-weight: 900;
        font-size: 21px;
        
    }
    
    .table.mycomTable{
            width: 100% !important;
    }
    table.table.mycomTable tr th,
    table.table.mycomTable tr td,
    table.table.mycomTable tr th:last-child,
    table.table.mycomTable tr td:last-child{
        width :auto !important;
        display :table-cell;
        border:none !important;
        padding :8px 10px;
    }
    table.table.mycomTable tr th:last-child,
    table.table.mycomTable tr td:last-child{
        width :40% !important;
    }
    .table.mycomTable tr th:last-child,
    .table.mycomTable tr td:last-child{
        text-align: center; 
    } 
    
    .table.mycomTable tbody tr{
        border-top: 1px solid #54b7d8; 
        border-bottom: 1px solid #54b7d8; 
    }
    .table.mycomTable tr th:last-child,
    .table.mycomTable tr td:last-child{ 
        display :table-cell ;
    }
     
 
    table.table.mycomTable tr th{ 
        font-size: large;
    }
    
    input[type="button"]:hover, input[type="submit"]:hover, div.form-submit button:hover,
    input[type="button"]:active, input[type="submit"]:active, div.form-submit button:active{
        background-image: -webkit-gradient(linear,0 0,0 100%,from(#3A85EC),to(#0056CC));
        background: #0056CC;
        color: white;
    }
    body.background-image div.row-fluid{
        width: 100% !important;
        margin-left: 0;
        margin-right: 0;
        padding: 2px 8px;
    }
    
    
    label,h1{
               color: #397fc0;
    }
    
    input{
            background-color: #f7f7f7 !important;
    }
    /* [class^="icon-"], [class*=" icon-"] {
    background-image: initial !important;
} */
      @media only screen and (max-width: 500px) and (min-width: 320px) {
        /* [class^="icon-"], [class*=" icon-"] {
    background-image: initial !important;
} */
    table.table.table-striped.mycomTable tr td:nth-child(1), table.table.table-striped.mycomTable tr th:nth-child(1), table.table.table-striped.mycomTable tr td:nth-child(2), table.table.table-striped.mycomTable tr th:nth-child(2), table.table.table-striped.mycomTable tr td:last-child, table.table.table-striped.mycomTable tr th:last-child {
    /* display: table-cell !important;  */
    width: 18% !important;
}
table.table.table-striped.mycomTable tr td:nth-child(2), table.table.table-striped.mycomTable tr th:nth-child(2),
 table.table.table-striped.mycomTable tr td:nth-child(4), table.table.table-striped.mycomTable tr th:nth-child(4) {
    display: none !important; 
    width: 18% !important;
}
 table.table.table-striped.mycomTable tr td:last-child, table.table.table-striped.mycomTable tr th:last-child {
    display: table-cell !important;  
}
    table.table.table-striped.mycomTable tr td, table.table.table-striped.mycomTable tr th {
    /* display: none !important;  */
}
table.table thead tr th {
    font-size: 12px !important;
}
.icon-trash{

 display: initial!important; 
}
.span12 a.btn .icon-trash{
    display: block !important;
}
      }
      
      
      @media only screen and (max-width: 500px) and (min-width: 320px) {

.row-fluid [class*="span"], .span12{
    margin-right: 9% !important;  
}

.row-fluid .span12 { 
    width: 90% !important;  
}

.span12 a.btn {
    display: initial !important;
    padding: 5px 6px;
        margin: 0px 1px !important;
        width: 22px;
}
.span12 a.btn .icon-trash{
    display: block !important;
}

div.filterBtn{
        display: block !important;
}
form#ordersfilter{
        display: grid !important;
}
}
    @media print{

         a,a.btn,#ordersfilter,.navbar,table.table tbody tr td:last-child,footer,#order-total{
               display: none;
         }

          table td{
              font-size: 14px;
          }
          table td, table th{
                padding: 1px !important;
         }
             tr   {  page-break-before: always; }
        @page {
                margin-bottom: 1.0cm;   
                margin-top: 1.0cm;                
               margin-left: -0.5cm; 
               margin-right: 0.0cm; 
              }
        hr {
                margin-left: 60px !important;
              }      
        table { page-break-inside:auto;
                padding: 40px !important;}

     }
     
     <?php if(1==0) { ?>
</style>
    
     <?php } ?>