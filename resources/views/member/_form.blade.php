<div class="panel-content">
    <div class="row">
        <div class="col-9">
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="first_name">Title </label>
                    <select name="salutation_id" id="salutation_id" class="form-control  @error('salutation_id') is-invalid @enderror">
                        @foreach($salutations as $id => $salutation)
                            <option value="{{ $id }}" @if($flag) selected @endif>{{ $salutation }}</option>
                        @endforeach
                    </select>
                    @error('salutation_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="first_name">First name <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control  @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="First name" value="@if($flag){{ $member['first_name'] }} @else {{ old('first_name') }} @endif" required>
                    @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="middle_name">Middle name</label>
                    <input type="text" class="form-control  @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" placeholder="Middle name" value="@if($flag){{ $member['middle_name'] }} @else {{ old('middle_name') }} @endif">
                    @error('middle_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="surname">Surname <span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('surname') is-invalid @enderror" id="surname" name="surname" placeholder="Surname" value="@if($flag){{ $member['surname'] }} @else {{ old('surname') }} @endif" required>
                    @error('surname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="tel">Mobile number <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-phone width-1 text-align-center"></i></span>
                        </div>
                        <input type="text" name="tel"  placeholder="Mobile Number" data-inputmask="'mask': '99999999999'"  class="form-control @error('tel') is-invalid @enderror" id="tel" value="@if($flag){{ $member['tel'] }} @else {{ old('tel') }} @endif">
                    </div>
                    @error('tel')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="email">Email Address </label>
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="@if($flag){{ $member['email'] }} @else {{ old('email') }} @endif">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="birthday">Date of Birth <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control  @error('birthday') is-invalid @enderror" name="birthday" placeholder="Date of Birth" id="datepicker-4-2" required value="@if($flag){{ $member['birthday'] }} @else {{ old('birthday') }} @endif">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-times"></i>
                            </span>
                        </div>
                    </div>
                    @error('birthday')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <img src="{{ URL::to('img/avatar-m.png') }}" id="blah" width="120" height="100" alt=""><br>
                    <input type="file" class="form-control  @error('photo') is-invalid @enderror" id="photo" @if($flag) disabled @endif  name="photo" onchange="previewFile()">
                    @error('photo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col-12 mb-3">
            <label class="form-label" for="address">Home Address <span class="text-danger">*</span></label>
            {{-- <textarea class="form-control  @error('address') is-invalid @enderror" id="address" name="address" placeholder="Home Address" required="">@if($flag){{ $member['address'] }} @else {{ old('address') }} @endif</textarea> --}}
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Home Address" required="" @if($flag) value="{{ $member['address'] }}" @else {{ old('address') }} @endif />
            <input type="hidden" name="lat" id="lat" />
            <input type="hidden" name="lng" id="lng" />
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <hr>
    <div style="background:gray;color:white; margin-left:2px;">
        <h1 class="">Member Decision</h1>
    </div>
    <div class="form-row">
        <div class="col-4 mb-3">
            <label class="form-label" for="serivice_interest_id">Member Group <span class="text-danger">*</span></label>
            <select class="custom-select  @error('member_group_id') is-invalid @enderror" required="" id="member_group_id" name="member_group_id" required>
                @foreach($member_groups as $id => $name)
                    <option value="{{ $id }}" @if($flag) selected @endif>{{ $name}}</option>
                @endforeach
            </select>
            @error('member_group_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-4 mb-3">
            <label class="form-label" for="serivice_interest_id">Service Attended <span class="text-danger">*</span></label>
            <select class="custom-select  @error('service_interest_id') is-invalid @enderror" required="" id="service_interest_id" name="service_interest_id" required>
                @foreach($service_interests as $id => $service_interest)
                    <option value="{{ $id }}" @if($flag) selected @endif>{{ $service_interest }}</option>
                @endforeach
            </select>
            @error('service_interest_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-4 mb-3">
            <label class="form-label" for="login_details">Create Login Details(Only for those with Smartphone)</label>
            <select class="custom-select" id="login_details" name="login_details">
                <option value="0" selected="true">NO</option>
                <option value="1" >Yes</option>
            </select>
        </div>
    </div>
    <div class="panel-tag">
        <div class="form-row">
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('first_time_visitor') is-invalid @enderror" id="first_time_visitor" name="first_time_visitor">
                <label class="custom-control-label" for="first_time_visitor">First Time Visitor? </label>
                @error('first_time_visitor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('returning_visitor') is-invalid @enderror" id="returning_visitor" name="returning_visitor" >
                <label class="custom-control-label" for="returning_visitor">Returning Visitor? </label>
                @error('returning_visitor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('new_resident') is-invalid @enderror" id="new_resident" name="new_resident" >
                <label class="custom-control-label" for="new_resident">New Resident? </label>
                @error('new_resident')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('membership_interest') is-invalid @enderror" id="membership_interest" name="membership_interest" >
                <label class="custom-control-label" for="membership_interest">Would you like to a Member? </label>
                @error('membership_interest')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('workforce_interest') is-invalid @enderror" id="workforce_interest" name="workforce_interest">
                <label class="custom-control-label" for="workforce_interest">Would you want to Join the workforce? </label>
                @error('workforce_interest')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('like_visited') is-invalid @enderror" id="like_visited" name="like_visited" onclick="visitFunction()" >
                <label class="custom-control-label" for="like_visited">Would you want to be visited? </label>
                @error('like_visited')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row" id="availability1" style="display: none;">
            <div class="col-12 mb-3">
                <label class="form-label" for="availability">If yes, when Available? </label>
                <input type="text" class="form-control  @error('availability') is-invalid @enderror" id="availability" name="availability" >
                @error('availability')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('save_before') is-invalid @enderror" id="save_before" name="save_before" >
                <label class="custom-control-label" for="save_before">Have you been save before? </label>
                @error('save_before')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input  @error('baptized') is-invalid @enderror" id="baptized" name="baptized" onclick="baptizedFunction()" >
                <label class="custom-control-label" for="baptized">Are you baptized? </label>
                @error('baptized')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row" id="life_experience" style="display:none;">
            <div class="col-12 mb-3">
                <label class="form-label" for="past_life_experience">Kindly state some of your past life experience</label>
                <textarea rows="3" name="past_life_experience" id="past_life_experience" class="form-control  @error('past_life_experience') is-invalid @enderror"></textarea>
                @error('past_life_experience')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="custom-control custom-checkbox col-md-4 mb-3">
                <input type="checkbox" class="custom-control-input @error('comment1') is-invalid @enderror" name="comment1" id="comment1" onclick="commentFunction()" >
                <label class="custom-control-label" for="comment1">Any comment about our service? </label>
                @error('comment1')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="custom-control custom-checkbox col-md-8 mb-3" id="comment" style="display:none;">
                <div class="form-row">
                    <div class="col-12 mb-3">
                        <label class="form-label" for="comment">Comment Box</label>
                        <textarea rows="3" name="comment" class="form-control  @error('comment') is-invalid @enderror"></textarea>
                        @error('comment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background:gray;color:white; margin-left:2px;">
        <h1 class="">Prayer Requests:</h1>
    </div>
    <hr>
    <table class="table" id="dynamic_field">
        <tbody>
                <tr>
                    <td width="700">
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <input type="text" class="form-control  @error('prayer_point') is-invalid @enderror" id="prayer_point" name="prayer_point[]" placeholder="Prayer Point" value="{{ old('paryer_point') }}">
                                @error('paryer_point')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <button" class="btn btn-primary ml-auto" name="add" id="add" tooltips="Add more">
                                    <i class="fal fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
        </tbody>
    </table>
</div>