<?php
header("Content-Type:text/css");
$color = "#f0f"; 
$secondColor = "#ff8"; 

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}

?>

.cmn--btn, .cmn--table thead tr th, .trade--tabs .nav-item .nav-link.active, .faq__item.open .faq__title, .faq__item .faq__title .right__icon::before, .faq__item .faq__title .right__icon::after, div[class*="col"]:nth-child(2) .footer__contact__item, .dashboard__item .dashboard__thumb, .dashboard-dashboard-icon .dashboard-menu li:hover > a
{
    background-color: <?php echo $color ?>;

}

.predict-type-item .icon, .feature__item .feature__thumb i, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .post__item .post__content .meta__date .meta__item i, .post__item .post__read, .highlow-time-duration li a i{
    color: <?php echo $color ?>;
}

.post__item .post__content .meta__date {
    border-left: 5px solid <?php echo $color ?>;
}

.btn--base, .badge--base, .bg--base
{
    background-color: <?php echo $color ?> !important;
}

.text--base {
    color: <?php echo $color ?> !important;
}

.btn--info, .badge--info, .bg--info {
    background-color: <?php echo $color ?> !important;
}

@media (min-width: 992px){

.menu li .submenu li:hover > a {
background: <?php echo $color ?>;

}

.cmn--btn:hover {
    border-color:  <?php echo $color ?>;
}

.footer__widget .widget__links li a:hover{
    color: <?php echo $color ?>;
}

}


@media screen and (max-width: 600px) {

img.crypto-img {
width: 100%;
}

}




