
    {{ Form::open(array('url' => route('save-property-reviews'), 'id' =>'add-property-reviews' )) }}
    <h4 class="modal-body-heading text-center">Add Review</h4>
    {{--Note Section Start--}}
    {{--<div class="alert alert-modal-success">
        Your rating has been recorded. Please select reason and add comment for the property owner.
    </div>--}}
    {{--Note Section End--}}
    <div class="row">
        <div class="rating col-sm-12">
            <div class="form-group clearfix mb-15">
                <span class="rating-input-label pull-left mr-5 font-14">Your Rating: </span>
                <div class="property-rating-input pull-left">
                    <div class="star-rating">
                        <div class="star-rating__wrap">
                            <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5">
                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4">
                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3">
                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2">
                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-1" type="radio" checked name="rating" value="1">
                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
                        </div>
                    </div>
                </div>

            </div>
            <label class="help-block"></label>
        </div>
        <div class="col-sm-12 reason_for_rating">
            <div class="form-group">
                {{Form::label('reason_for_rating', 'What is the main reason for your rating?', array('class' => ''))}} <span class="text-danger">*</span> <select id="select-rating-reason" name="reason_for_rating" class="selectpicker search-fields select-rating-reason">
                    <option value="">Select reason</option>
                    @foreach(\Config::get('constants.PROPERTY_REVIEW_REASON') as $key => $value)
                        <option value="{{$value}}">{{$value}}</option>
                    @endforeach
                </select>

            </div>
            <label class="help-block"></label>
        </div>

        <div class="col-sm-12">
            <div class="form-group mb-0">
                {{Form::label('comments', 'Comments', array('class' => ''))}} <span class="text-danger">*</span>
                {{Form::textarea('comments', null, array( 'class' => 'form-control textarea-no-resize', 'rows'=>'5', 'id'=> 'comments', 'maxlength'=> '150' ))}}
                <label class="help-block"></label>
            </div>

        </div>
    </div>

    <div class="modal-footer bt-0">
        <button type="button" class="button-md button-md-modal  button-default mr-5" data-dismiss="modal">CANCEL</button>
        {{Form::submit('SUBMIT',array('class' => 'button-md button-md-modal button-theme', 'id'=>'ss'))}}
    </div>
    {{ Form::close() }}

 