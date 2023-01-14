@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="faqs-sectioin pt-120 pb-120">
        <div class="container">
           <div class="row">
           		<div class="col-lg-12">
           			 @php echo $data->data_values->description @endphp
           		</div>
           </div>
        </div>
    </div>
@endsection