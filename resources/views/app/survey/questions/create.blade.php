@extends('layouts.app')
@section('title','Survey')
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0"> Survey - {!! $survey->title !!} - Questions </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Survey</a></li>
                     <li class="breadcrumb-item"><a href="#">{!! $survey->title !!}</a></li>
                     <li class="breadcrumb-item active">Questions</li>
                     <li class="breadcrumb-item active">Add</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row">
      <div class="col-md-6">
         @include('app.survey._menu')
      </div>
   </div>
   <div class="card mt-2">
      <div class="card-body">
         <form action="{!! route('survey.questions.store',$survey->code) !!}" method="post" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
               <div class="form-group mb-1">
                  <label for="">Question Type</label>
                  {!! Form::select('type',$types,null,['id'=>'question_types','class'=>'form-control','required'=>'']) !!}
               </div>
               <div class="form-group mb-1">
                  <label for="">Question</label>
                  {!! Form::textarea('question',null,['class'=>'form-control my-editor','size'=>'3x3']) !!}
               </div>
            </div>
            <div class="col-md-6">
               <div class="row" id="multichoice"  style="display: none">
                  <div class="col-md-8">
                     <div class="form-group mb-1 col-md-12">
                        <label for="input-1" class="d-block">Option</label>
                        <input type="text" placeholder="Option A" name="option_a" class="form-control">
                     </div>
                     <div class="form-group mb-1 col-md-12">
                        <div>
                           <input type="text" placeholder="Option B" name="option_b" class="form-control">
                        </div>
                     </div>
                     <div class="form-group col-md-12">
                        <div>
                           <input type="text" placeholder="Option C" name="option_c" class="form-control">
                        </div>
                     </div>
                     <div class="form-group col-md-12">
                        <div>
                           <input type="text" placeholder="Option D" name="option_d" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group col-md-12">
                        <label class="d-block">Is correct option?</label>
                        <div><input type="radio" name="correct" value="option_a" style="margin: 14px;"></div>
                     </div>
                     <div class="form-group col-md-12">
                        <div><input type="radio" name="correct" value="option_b" style="margin: 14px;"></div>
                     </div>
                     <div class="form-group col-md-12">
                        <div><input type="radio" name="correct" value="option_c" style="margin: 14px;"></div>
                     </div>
                     <div class="form-group col-md-12">
                        <div><input type="radio" name="correct" value="option_d" style="margin: 14px;"></div>
                     </div>
                  </div>
               </div>
               <div class="row" id="true_false" style="display: none">
                  <div class="col-md-8">
                     <div class="form-group col-md-12">
                        <label for="input-1" class="d-block">Option</label>
                        <div><input type="text" name="option_a" placeholder="TRUE" value="TRUE" class="form-control"></div>
                     </div>
                     <div class="form-group col-md-12">
                        <div><input type="text" name="option_b" placeholder="FALSE" value="FALSE" class="form-control"></div>
                     </div>
                  </div>
                  <div class="col col-md-4">
                     <div class="form-group col-md-12">
                        <label for="input-1" class="d-block">Is correct option?</label>
                        <div><input type="radio" name="correct" value="option_a" style="margin: 14px;"></div>
                     </div>
                     <div class="form-group col-md-12">
                        <div><input type="radio" name="correct" value="option_b" style="margin: 14px;"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <button type="submit" class="btn btn-success btn-sm submit float-right"><i class="fad fa-save"></i> Add Question</button>
               <img src="{!! asset('assets/images/loader.gif') !!}" alt="" class="submit-load float-right" style="width: 10%">
            </div>
         </form>
      </div>
   </div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
		$('#question_types').on('change', function() {
			if (this.value == 1) {
				$('#multichoice').show();
			} else {
				$('#multichoice').hide();
			}

			if (this.value == 2) {
				$('#true_false').show();
			} else {
				$('#true_false').hide();
			}
		});
	});
</script>
@endsection
