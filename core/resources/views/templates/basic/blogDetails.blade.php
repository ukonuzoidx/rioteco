@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
    <section class="blog-section bg--section pt-120 pb-120">
		<div class="container">
			<div class="row gy-5 justify-content-center">
				<div class="col-lg-8">
					<div class="post__details pb-50">
						<div class="post__header">
							<h3 class="post__title">
								{{__($blog->data_values->title)}}
							</h3>
						</div>
						<div class="post__thumb">
							<img src="{{ getImage('assets/images/frontend/blog/'. $blog->data_values->blog_image_1, '728x465')}}" alt="@lang('blog')">
						</div>
						<p class="text-white">
							@php echo $blog->data_values->description_nic @endphp
						</p>
						<div class="row gy-4 justify-content-between">
							<div class="col-md-6">
								<h6 class="post__share__title">@lang('Share now')</h6>
								<ul class="post__share">
									<li>
										<a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}">
											<i class="lab la-facebook-f"></i>
										</a>
									</li>
									<li>
										<a href="https://twitter.com/intent/tweet?text=Post and Share &amp;url={{urlencode(url()->current()) }}">
											<i class="lab la-twitter"></i>
										</a>
									</li>
								
									<li>
										<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}">
											<i class="lab la-linkedin-in"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="text-white">
						<div class="fb-comments" data-width="100%" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
					</div>
				</div>
				<div class="col-lg-4">
					<aside class="blog-sidebar bg--body">
						<div class="widget widget__post__area">
							<h4 class="widget__title">@lang('Recent Post')</h4>
							<ul>
								@foreach($recentBlog as $blog)
								<li>
									<a href="{{ route('blog.details', [$blog->id, str_slug($blog->data_values->title)]) }}" class="widget__post">
										<div class="widget__post__thumb">
											<img src="{{ getImage('assets/images/frontend/blog/'. $blog->data_values->blog_image_1, '728x465')}}" alt="@lang('blog')">
										</div>
										<div class="widget__post__content">
											<h6 class="widget__post__title">
												{{__($blog->data_values->title)}}
											</h6>
											<span>{{showDateTime($blog->created_at, 'd M Y')}}</span>
										</div>
									</a>
								</li>
								@endforeach
							</ul>
						</div>
					</aside>
				</div>
			</div>
		</div>
	</section>
@endsection
