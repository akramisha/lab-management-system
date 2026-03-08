@extends('base')

@section('content')
 <div class="container mt-5" style="max-width: 400px;">
          <h2 class="text-center mb-4">Login Your Account</h2>
          <form method="POST" action="/helo">
                @csrf
                
                <div class="mb-3">
                 <label class="form-label">Email address</label>
                 <input type="email" class="form-control" name="email" required autofocus>
                </div>
                <div class="mb-3">
                 <label  class="form-label">Password</label>
                 <input type="password" class="form-control"  name="password" required>
                </div>
                <div class="d-grid">
                 <button type="submit" class="task-btn" >Login</button>
                </div>
          </form>
     </div>
    
@endsection