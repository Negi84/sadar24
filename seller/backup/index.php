<?php include('connect.php');
if(isset($_POST['Ssubmit'])){
	$mobile = $_POST['phone_number'];
	
	$result = $conn->query("SELECT phone FROM tbl_seller_query WHERE phone = '$mobile'");

if (!$result) {
  die($conn->error);
}
if ($result->num_rows > 0) {
	header("Location: https://sadar24.com/home/vendor_logup/registration/"); 
}else{
	$sql = "INSERT INTO tbl_seller_query (phone) VALUES ('.$mobile.')";
if ($conn->query($sql) === TRUE) {
   header("Location: https://sadar24.com/home/vendor_logup/registration/"); 
} else {
  $error = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
}
?>
<!doctype html>
<html lang="en">
 <?php
include('head.php') 
 ?> 
<body class="hideSideMenu">
<?php if(isset($error)){ ?>
<div class="alert alert-danger">
  <strong><?php echo $error;?></strong>
</div>
 <?php
}
include('header.php') 
 ?> 
<!--Header Close-->

<div class="clearfix"></div>
<section class="seller-carousel">
<div class="container container-header">
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-2-mobile">
<div class="banner-caption">
<h1>Grow your business faster by selling on Sadar24</h1>
<h4>India's largest Reselling platform with lowest commission rates</h4>
<div class="button-banner">
<a href="javascript:void(0)" class="btn-quote" data-toggle="modal" data-target="#myModal">START SELLING</a>
</div>
</div>
</div>


<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1-mobile">
<figure class="collage-banner text-right">
<img data-src="seller/images/banner-01.jpg" alt="slider" class="lazyload w-100 img-fluid"> 
</figure>
</div>

</div>
</div>
</section>
<div class="clearfix"></div>

<section class="with-100 position-relative pt-5 pb-5 bgGradiant-grey">
<div class="container container-header">
<div class="row">
<div class="col-md-12">
<div class="header-h2-main text-center">
<h2>Join a Creative Market Place</h2>
</div>
</div>
</div>


<div class="row mt-5">
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
<div class="creative-icons">
<figure class="icons">
<img data-src="seller/images/icons-seller/01-03.svg" alt="logo" class="lazyload img-fluid">    
</figure>
<div class="icons-contents">
<h4>Low Fees</h4>
<p>It does not take much to list your products and once you make a sale, our fee is just reasonble.</p>
</div>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
<div class="creative-icons">
<figure class="icons">
<img data-src="seller/images/icons-seller/01-04.svg" alt="logo" class="lazyload img-fluid">    
</figure>
<div class="icons-contents">
<h4>Powerful Tools</h4>
<p>Our tools and services make it easy to manage, promote and grow your business.</p>
</div>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
<div class="creative-icons">
<figure class="icons">
<img data-src="seller/images/icons-seller/01-05.svg" alt="logo" class="lazyload img-fluid">    
</figure>
<div class="icons-contents">
<h4>Support and Education</h4>
<p>Reach out to us for help anytime and learn how to sell successfully.</p>
</div>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
<div class="creative-icons">
<figure class="icons">
<img data-src="seller/images/icons-seller/01-06.svg" alt="logo" class="lazyload img-fluid">    
</figure>
<div class="icons-contents">
<h4>Secure Marketplace</h4>
<p>A niche marketplace catering to a large range of customers with huge variety of products.</p>
</div>
</div>
</div>


</div>

</div>
</section>
<div class="clearfix"></div>

<section class="with-100 position-relative pt-5 pb-5 bg-white">
<div class="container container-header">
<div class="row justify-content-center">
<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
<figure class="mrkt-place text-center">
<img data-src="seller/images/seller-01-mrkt.jpg" alt="logo" class="lazyload img-fluid">
<div class="circle">
<img data-src="seller/images/seller-01circle-mrkt.jpg" alt="logo" class="lazyload img-fluid">
</div>
</figure>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    <div class="content-mrkt-places">
        <h4>Why Sell On A Niche Marketplace</h4>
      <ul>
<li>It helps focus on a specific product category that is in demand &amp; ensures variety</li>
<li>Helps in Targeting a more specific and involved group of customers</li>
<li>Ability to address the needs of those customers by offering a more holistic set of specialized products</li>
<li>The engagement and interaction with customers is higher, more personal and thematic, leading to repeat visits</li>
<li>Draws in lots of digital traffic, which means greater exposure for the brands that want to sell.</li>
<li>Brand Identity gets defined and embedded in the customer’s consciousness with their category-specific approach</li>
<li>Gives consumers the ease of shopping for their specific needs at their own disposal</li>
<li> Generates a sense of community, trust and support that shares a common greater interest.</li>
</ul>
        
    </div>
</div>

</div>
</div>
</section>

<div class="clearfix"></div>

<section class="with-100 position-relative paddingCustomize bg-line-moving">
<div class="container container-header">
<div class="row justify-content-center">
<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
<figure class="mrkt-place text-center">
<img data-src="seller/images/seller-02-mrkt.jpg" alt="logo" class="lazyload img-fluid">
<div class="circle">
<img data-src="seller/images/seller-02circle-mrkt.jpg" alt="logo" class="lazyload img-fluid">
</div>
</figure>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    <div class="content-mrkt-places">
        <h4>Doing Business With Us Is Easy</h4>
<ul>
<li>Listing on our platform is totally free with easy to use self-serve portal.</li>
<li>Pay only when your product is ordered.</li>
<li>We would be charging only the basic marketplace fees.</li>
<li>Maximize your sales across India with easy dashboard and analytics support</li>
<li>Hassle-free pick-up and delivery across India.</li>
<li>Package would be picked-up by our logistic partner once you pack and keep the product ready</li>
<li>Receive on time and reliable payments</li>
<li>Maximize your sales across India with easy dashboard and analytics support</li>
<li>Pay Only when your product is ordered</li>
</ul>
        
    </div>
</div>

</div>
</div>
</section>
<div class="clearfix"></div>


<section class="with-100 position-relative">
<div class="container bg-white shodow-custom conatinerpadding">
<div class="row">
<div class="col-md-12">
<div class="header-h2-main text-center">
<h2>Why Sell On Sadar24</h2>
</div>
</div>    
</div>



<div class="row justify-content-center mt-5">
<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-07.svg" alt="logo" class="lazyload img-fluid">    
</figure>    
<h5>Growth</h5>
<p>Widen your reach and increase sales</p>
</div>
</div>


<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-08.svg" alt="logo" class="lazyload img-fluid">  
</figure>     
<h5>No Upfront</h5>
<p>Sell Online with no upfront or recurring cost</p>
</div>
</div>


<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-11.svg" alt="logo" class="lazyload img-fluid">  
</figure>     
<h5>Easily Accessible</h5>
<p>Manage your online store anytime and anywhere**</p>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-09.svg" alt="logo" class="lazyload img-fluid">  
</figure>     
<h5>Effective Model</h5>    
<p>Cost effective and scalable model**</p>
</div>
</div>

</div>
<div class="row justify-content-center mt-5">
<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-10.svg" alt="logo" class="lazyload img-fluid"> 
</figure>    
<h5>Visibility</h5>
<p>Equal Opportunities for all the Sellers to flourish</p>
</div>
</div>


<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-12.svg" alt="logo" class="lazyload img-fluid"> 
</figure>     
<h5>Performance</h5>
<p>Performance based system, pay only if you sell.</p>
</div>
</div>


<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-13.svg" alt="logo" class="lazyload img-fluid"> 
</figure>     
<h5>Easy as ABC</h5>
<p>Register, list your products and start selling. Simple!</p>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
<div class="leaf-col-flex leaf-text text-left">
<figure class="icon-leval-2">
<img data-src="seller/images/icons-seller/01-14.svg" alt="logo" class="lazyload img-fluid"> 
</figure>     
<h5>Help and Support</h5>    
<p>Reach out to us for help and support anytime</p>
</div>
</div>

</div>

<div class="row mt-5">
<div class="col-md-12 text-center">
<div class="button-banner">
<a href="javascript:void(0)" class="btn-quote" data-toggle="modal" data-target="#myModal">START SELLING</a>
</div>    
</div>
</div>
</div>
</section>

<div class="clearfix"></div>

<section class="with-100 position-relative pt-5 pb-5 bg-white mt-3">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="header-h2-main text-center">
<h2>Why Choose Us!</h2>
</div>
</div>
</div> 

<div class="row justify-content-center mt-5">
<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
<div class="whyChoseUs">
<h2>01</h2>    
<p>Free listing on the our platform with easy to use the self-serve portal.</p>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
<div class="whyChoseUs">
    <h2>02</h2>
<p>Hassle-free pick-up and delivery across India.</p>
</div>
</div>


<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
<div class="whyChoseUs">
      <h2>03</h2>
<p>Pay after you receive an order for your product.</p>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
<div class="whyChoseUs">
  <h2>04</h2>    
<p>Maximize your sales across India with easy dashboard and analytics support.</p>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
<div class="whyChoseUs">
      <h2>05</h2>
<p>We would be charging only the basic marketplace fees.</p>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 pl-2 pr-2">
<div class="whyChoseUs">
  <h2>06</h2>    
<p>The package would be shipped by our logistics partners (can also be self-shipped) after you pack and keep the product ready</p>
</div>
</div>
</div>

    
</div>
</section>

<div class="clearfix"></div>
<?php
include('footer.php');
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php
include('javascript.php');
?>

</body>
</html>