<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(1==0){ ?>
    <style>
    <?php }
    ?>
    

.checkboxDiv{
    display: inline-flex !important;
}

.displayCheck{
    display:grid !important;

}

label {
    display: inline-flex !important; 
}

input[type="checkbox"]:focus, 
input[type="radio"]:focus
{
    border-color: rgba(82,168,236,0.8);
    outline: 0;
    outline: thin dotted \9;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(82,168,236,0.6);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(82,168,236,0.6);
}

input.phoneNumberBox   {
    
    width: 70% !important;
    }
    
    select.phoneNumberCodeBox  {
        
    width: 22% !important;
    }
 

@media only screen and (max-width: 360px) and (min-width: 200px) {

    input.phoneNumberBox   {
        
    width: 56% !important;
    }

    select.phoneNumberCodeBox  {
        
    width: 28% !important;
    }

}

/* @media only screen and (max-width: 359px) and (min-width: 350px){
    input.phoneNumberBox {
        width: 56% !important;
    }

    select.phoneNumberCodeBox  {
        
        width: 28% !important;
        }
} */

@media only screen and (max-width: 458px) and (min-width: 360px) {

input.phoneNumberBox   {
    
width: 60% !important;
}

select.phoneNumberCodeBox  {
    
width: 28% !important;
}

}
@media only screen and (max-width: 584px) and (min-width: 459px) {

input.phoneNumberBox   {
    
width: 56% !important;
}

select.phoneNumberCodeBox  {
    
width: 31% !important;
}

}


@media only screen and (max-width:619px) and (min-width: 584px) {

input.phoneNumberBox   {
    
width: 60% !important;
}

select.phoneNumberCodeBox  {
    
width: 31% !important;
}

}



@media only screen and (max-width: 815px) and (min-width: 620px) {

input.phoneNumberBox   {
    
width: 56% !important;
}

select.phoneNumberCodeBox  {
    
width: 25% !important;
}

}


@media only screen and (max-width: 1022px) and (min-width: 816px) {

input.phoneNumberBox   {
    
width: 60% !important;
}

select.phoneNumberCodeBox  {
    
width: 29% !important;
}

}
@media (max-width: 464px) {
select[name$="_date"] {    
    width: 27% !important;
}
select[name$="_month"] {    
    width: 27% !important;
}
select[name$="_year"] {    
    width: 37% !important;
}
}
