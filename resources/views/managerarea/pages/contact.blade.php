{{-- Master Layout --}}
@extends('cortex/foundation::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ trans('cortex/contacts::common.contacts') }} » {{ $contact->exists ? $contact->full_name : trans('cortex/contacts::common.create_contact') }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Contacts\Http\Requests\Managerarea\ContactFormRequest::class)->selector("#managerarea-contacts-create-form, #managerarea-contacts-{$contact->getKey()}-update-form") !!}

    <script>
        window.countries = {!! $countries !!};
        window.selectedCountry = '{{ old('country_code', $contact->country_code) }}';
    </script>
@endpush

{{-- Main Content --}}
@section('content')

    @if($contact->exists)
        @include('cortex/foundation::common.partials.confirm-deletion')
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @if($contact->exists && $currentUser->can('delete', $contact)) <div class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-modal-action="{{ route('managerarea.contacts.destroy', ['contact' => $contact]) }}" data-modal-title="{!! trans('cortex/foundation::messages.delete_confirmation_title') !!}" data-modal-body="{!! trans('cortex/foundation::messages.delete_confirmation_body', ['type' => 'contact', 'name' => $contact->full_name]) !!}" title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i></a></div> @endif
                {!! Menu::render('managerarea.contacts.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($contact->exists)
                            {{ Form::model($contact, ['url' => route('managerarea.contacts.update', ['contact' => $contact]), 'method' => 'put', 'id' => "managerarea-contacts-{$contact->getKey()}-update-form"]) }}
                        @else
                            {{ Form::model($contact, ['url' => route('managerarea.contacts.store'), 'id' => 'managerarea-contacts-create-form']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Full Name --}}
                                    <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                        {{ Form::label('full_name', trans('cortex/contacts::common.full_name'), ['class' => 'control-label']) }}
                                        {{ Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.full_name'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('full_name'))
                                            <span class="help-block">{{ $errors->first('full_name') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Title --}}
                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        {{ Form::label('title', trans('cortex/contacts::common.title'), ['class' => 'control-label']) }}
                                        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.title')]) }}

                                        @if ($errors->has('title'))
                                            <span class="help-block">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Gender --}}
                                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                        {{ Form::label('gender', trans('cortex/contacts::common.gender'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('gender', '') }}
                                        {{ Form::select('gender', $genders, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/contacts::common.select_gender'), 'data-allow-clear' => 'true', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('gender'))
                                            <span class="help-block">{{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">


                                <div class="col-md-4">

                                    {{-- Email --}}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {{ Form::label('email', trans('cortex/contacts::common.email'), ['class' => 'control-label']) }}
                                        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.email'), 'required' => 'required']) }}

                                        @if ($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Phone --}}
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {{ Form::label('phone', trans('cortex/contacts::common.phone'), ['class' => 'control-label']) }}
                                        {{ Form::number('phone', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.phone')]) }}

                                        @if ($errors->has('phone'))
                                            <span class="help-block">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Fax --}}
                                    <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                                        {{ Form::label('fax', trans('cortex/contacts::common.fax'), ['class' => 'control-label']) }}
                                        {{ Form::number('fax', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.fax')]) }}

                                        @if ($errors->has('fax'))
                                            <span class="help-block">{{ $errors->first('fax') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Birthday --}}
                                    <div class="form-group has-feedback{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                        {{ Form::label('birthday', trans('cortex/contacts::common.birthday'), ['class' => 'control-label']) }}
                                        {{ Form::text('birthday', null, ['class' => 'form-control datepicker', 'data-auto-update-input' => 'false']) }}
                                        <span class="fa fa-calendar form-control-feedback"></span>

                                        @if ($errors->has('birthday'))
                                            <span class="help-block">{{ $errors->first('birthday') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Language Code --}}
                                    <div class="form-group{{ $errors->has('language_code') ? ' has-error' : '' }}">
                                        {{ Form::label('language_code', trans('cortex/contacts::common.language'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('language_code', '') }}
                                        {{ Form::select('language_code', $languages, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/contacts::common.select_language'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('language_code'))
                                            <span class="help-block">{{ $errors->first('language_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Country Code --}}
                                    <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
                                        {{ Form::label('country_code', trans('cortex/contacts::common.country'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('country_code', '') }}
                                        {{ Form::select('country_code', [], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/contacts::common.select_country'), 'required' => 'required', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('country_code'))
                                            <span class="help-block">{{ $errors->first('country_code') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Skype --}}
                                    <div class="form-group{{ $errors->has('skype') ? ' has-error' : '' }}">
                                        {{ Form::label('skype', trans('cortex/contacts::common.skype'), ['class' => 'control-label']) }}
                                        {{ Form::text('skype', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.skype')]) }}

                                        @if ($errors->has('skype'))
                                            <span class="help-block">{{ $errors->first('skype') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Twitter --}}
                                    <div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }}">
                                        {{ Form::label('twitter', trans('cortex/contacts::common.twitter'), ['class' => 'control-label']) }}
                                        {{ Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.twitter')]) }}

                                        @if ($errors->has('twitter'))
                                            <span class="help-block">{{ $errors->first('twitter') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Facebook --}}
                                    <div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
                                        {{ Form::label('facebook', trans('cortex/contacts::common.facebook'), ['class' => 'control-label']) }}
                                        {{ Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.facebook')]) }}

                                        @if ($errors->has('facebook'))
                                            <span class="help-block">{{ $errors->first('facebook') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Google Plus --}}
                                    <div class="form-group{{ $errors->has('google_plus') ? ' has-error' : '' }}">
                                        {{ Form::label('google_plus', trans('cortex/contacts::common.google_plus'), ['class' => 'control-label']) }}
                                        {{ Form::text('google_plus', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.google_plus')]) }}

                                        @if ($errors->has('google_plus'))
                                            <span class="help-block">{{ $errors->first('google_plus') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Linkedin --}}
                                    <div class="form-group{{ $errors->has('linkedin') ? ' has-error' : '' }}">
                                        {{ Form::label('linkedin', trans('cortex/contacts::common.linkedin'), ['class' => 'control-label']) }}
                                        {{ Form::text('linkedin', null, ['class' => 'form-control', 'placeholder' => trans('cortex/contacts::common.linkedin')]) }}

                                        @if ($errors->has('linkedin'))
                                            <span class="help-block">{{ $errors->first('linkedin') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-2">

                                    {{-- Source --}}
                                    <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                                        {{ Form::label('source', trans('cortex/contacts::common.source'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('source', '') }}
                                        {{ Form::select('source', $sources, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/contacts::common.select_source'), 'data-tags' => 'true', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('source'))
                                            <span class="help-block">{{ $errors->first('source') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-2">

                                    {{-- Method --}}
                                    <div class="form-group{{ $errors->has('method') ? ' has-error' : '' }}">
                                        {{ Form::label('method', trans('cortex/contacts::common.method'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('method', '') }}
                                        {{ Form::select('method', $methods, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/contacts::common.select_method'), 'data-tags' => 'true', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('method'))
                                            <span class="help-block">{{ $errors->first('method') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/contacts::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::managerarea.partials.timestamps', ['model' => $contact])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
