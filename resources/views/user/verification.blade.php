@extends('front/layout')
@section('page_title','Category')
@section('container')

  <!-- product category -->
<section id="aa-product-category">
   <div class="container">
      <div class="row" style="text-align:center;">
        <br/><br/><br/>
            <h2 style="color: #3498db;">Your Email ID Verified Successfully!</h2>
            <p style="font-size: 18px; color: #555;">Thank you for verifying your email address. You can now enjoy full access to our website.</p>
            <br/><br/><br/>
            <a href="{{ route('/') }}" class="btn btn-primary">Explore Our Website</a>
      </div>
   </div>
</section>
@endsection
