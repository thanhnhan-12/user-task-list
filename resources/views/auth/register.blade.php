@extends('layout.layout')
@section('content')
    <div class="d-flex justify-content-center row align-items-center min-vh-100">
        <div class="col-lg-4">
            <div class="card ">
                <div class="card-header">
                    <h1 class="card-title">Register</h1>
                </div>
                <div class="card-body">
                    <form action={{ route('register.post') }} method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="name"
                                aria-describedby="emailHelp" placeholder="Username" required />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                aria-describedby="emailHelp" placeholder="Email" required />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required />
                        </div>
                        <p>Are you a member?<a href="/login"> Login</a> </p>

                        <div class="mb-3">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
