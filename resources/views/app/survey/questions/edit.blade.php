@extends('layouts.app')
@section('title','Survey | Questions')

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
                     <li class="breadcrumb-item active">Edit</li>
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
         {!! Form::model($question, ['route' => ['survey.questions.update',[$survey->code,$question->id]], 'method'=>'post','class'=>'row','enctype'=>'multipart/form-data']) !!}
            @csrf
            <input type="hidden" name="answerID" value="{!! $answers->id !!}">
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
               {{-- <div class="row">
                  <div class="col-md-12">
                     <div class="form-group mb-1 col-md-12">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control" id="thumbnail">
                        <small><a href="{!! asset('trivia/questions/'.$question->image) !!}" target="_blank">view Image</a></small>
                     </div>
                  </div>
               </div> --}}
               @if($question->type == 1)
                  <div class="row">
                     <div class="col-md-8">
                        <div class="form-group mb-1 col-md-12">
                           <label for="input-1">Option</label>
                           <input type="text" placeholder="Option A" name="option_a" value="{!! $answers->option_a !!}" class="form-control">
                        </div>
                        <div class="form-group mb-1 col-md-12">
                           <div>
                              <input type="text" placeholder="Option B" name="option_b" value="{!! $answers->option_b !!}" class="form-control">
                           </div>
                        </div>
                        <div class="form-group mb-1 col-md-12">
                           <div>
                              <input type="text" placeholder="Option C" name="option_c" value="{!! $answers->option_c !!}" class="form-control">
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div>
                              <input type="text" placeholder="Option D" name="option_d" value="{!! $answers->option_d !!}" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group col-md-12">
                           <label>Is correct option?</label>
                           <div><input type="radio" name="correct_answer" value="option_a" @if($answers->correct == 'option_a') checked @endif  style="margin: 14px;"></div>
                        </div>
                        <div class="form-group col-md-12">
                           <div><input type="radio" name="correct_answer" value="option_b" @if($answers->correct == 'option_b') checked @endif style="margin: 14px;"></div>
                        </div>
                        <div class="form-group col-md-12">
                           <div><input type="radio" name="correct_answer" value="option_c" @if($answers->correct == 'option_c') checked @endif style="margin: 14px;"></div>
                        </div>
                        <div class="form-group col-md-12">
                           <div><input type="radio" name="correct_answer" value="option_d" @if($answers->correct == 'option_d') checked @endif style="margin: 14px;"></div>
                        </div>
                     </div>
                  </div>
               @endif
               @if($question->type == 2)
                  <div class="row">
                     <div class="col-md-8">
                        <div class="form-group col-md-12">
                           <label for="input-1">Option</label>
                           <div><input type="text" name="true" placeholder="TRUE" value="{!! $answers->option_a !!}" class="form-control"></div>
                        </div>
                        <div class="form-group col-md-12">
                           <div><input type="text" name="false" placeholder="FALSE" value="{!! $answers->option_b !!}" class="form-control"></div>
                        </div>
                     </div>
                     <div class="col col-md-4">
                        <div class="form-group col-md-12">
                           <label for="input-1">Is correct option?</label>
                           <div><input type="radio" name="true_false_answer" value="option_a" @if($answers->correct == 'option_a') checked @endif style="margin: 14px;"></div>
                        </div>
                        <div class="form-group col-md-12">
                           <div><input type="radio" name="true_false_answer" value="option_b" @if($answers->correct == 'option_b') checked @endif style="margin: 14px;"></div>
                        </div>
                     </div>
                  </div>
               @endif
            </div>
            <div class="col-md-12">
               <button type="submit" class="btn btn-success btn-sm submit float-right"><i class="fad fa-save"></i> Update Question</button>
               <img src="{!! asset('assets/images/loader.gif') !!}" alt="" class="submit-load float-right" style="width: 10%">
            </div>
         {!! Form::close() !!}
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
