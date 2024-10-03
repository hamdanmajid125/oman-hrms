@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
        
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Profile</h4>

                </div>
                <div class="card-body p-4">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Home</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Messages</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#settings-1" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Settings</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home-1" role="tabpanel">
                            <p class="mb-0">
                                Raw denim you probably haven't heard of them jean shorts Austin.
                                Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache
                                cliche tempor, williamsburg carles vegan helvetica. Reprehenderit
                                butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi,
                                qui irure terry richardson ex squid. Aliquip placeat salvia cillum
                                iphone. Seitan aliquip quis cardigan american apparel, butcher
                                voluptate nisi qui.
                            </p>
                        </div>
                        <div class="tab-pane" id="profile-1" role="tabpanel">
                            <p class="mb-0">
                                Food truck fixie locavore, accusamus mcsweeney's marfa nulla
                                single-origin coffee squid. Exercitation +1 labore velit, blog
                                sartorial PBR leggings next level wes anderson artisan four loko
                                farm-to-table craft beer twee. Qui photo booth letterpress,
                                commodo enim craft beer mlkshk aliquip jean shorts ullamco ad
                                vinyl cillum PBR. Homo nostrud organic, assumenda labore
                                aesthetic magna 8-bit.
                            </p>
                        </div>
                        <div class="tab-pane" id="messages-1" role="tabpanel">
                            <p class="mb-0">
                                Etsy mixtape wayfarers, ethical wes anderson tofu before they
                                sold out mcsweeney's organic lomo retro fanny pack lo-fi
                                farm-to-table readymade. Messenger bag gentrify pitchfork
                                tattooed craft beer, iphone skateboard locavore carles etsy
                                salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                                Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                                mi whatever gluten-free.
                            </p>
                        </div>
                        <div class="tab-pane" id="settings-1" role="tabpanel">
                            <p class="mb-0">
                                Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                art party before they sold out master cleanse gluten-free squid
                                scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                art party locavore wolf cliche high life echo park Austin. Cred
                                vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                farm-to-table.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 m-auto text-center">
                        <div class="profile">
                            <label for="fileToUpload">
                                <div class="profile-pic" style="background-image: url({{ profileimage() }})">
                                    <span class="glyphicon glyphicon-camera"></span>
                                    <span class="span-camera"><i class="mdi mdi-camera-enhance-outline"></i></span>

                                </div>
                            </label>
                            <input type="File" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                    s
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" "name="name" type="text" value="" id="name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input class="form-control" name="name" type="email" value="" id="name">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
