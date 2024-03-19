@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-8 m-auto mt-5">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible text-white">
                    <ul class="text-white">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                <h5 class="font-weight-bolder mb-0">Create a user</h5>
                <div class="multisteps-form__content">
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12">
                                <label>Name</label>
                                <input name="name" class="multisteps-form__input form-control" type="text" placeholder="eg. Michael" onfocus="focused(this)" onfocusout="defocused(this)" required/>
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>Phone Number</label>
                                <input name="phone_number" class="multisteps-form__input form-control" type="text" placeholder="eg. Prior" onfocus="focused(this)" onfocusout="defocused(this)" required/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>Email Address</label>
                                <input
                                    name="email"
                                    class="multisteps-form__input form-control"
                                    type="email"
                                    placeholder="eg. soft@dashboard.com"
                                    onfocus="focused(this)"
                                    onfocusout="defocused(this)"
                                    data-temp-mail-org="0"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-6">
                                <label>Password</label>
                                <input name="password" class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)" required/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>Repeat Password</label>
                                <input name="password_confirmation" class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)" required/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>Image</label>
                                <input name="photo" class="multisteps-form__input form-control" type="file" onfocus="focused(this)" onfocusout="defocused(this)" accept="image/*" />
                            </div>
                        </div>
                        <div class="button-row d-flex mt-4">
                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
