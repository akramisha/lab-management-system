@extends('base')

@section('content')
 <div class="container mt-5" style="max-width: 400px;">
          <h2 class="text-center mb-4">Register Your Account</h2>
          <form method="POST" action="/hello">
                @csrf
                <div class="mb-3">
                 <label class="form-label">Username</label>
                 <input type="name" class="form-control" name="name" required autofocus>
                </div>
                <div class="mb-3">
                 <label class="form-label">Email address</label>
                 <input type="email" class="form-control" name="email" required autofocus>
                </div>
                <div class="mb-3">
                 <label  class="form-label">Contact</label>
                 <input type="phone" class="form-control"  name="contact" required>
                </div>
                <div class="mb-3">
                 <label  class="form-label">Address</label>
                    <textarea name="address" id="" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                 <label  class="form-label">Password</label>
                 <input type="password" class="form-control"  name="password" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Role:</label>
    <select name="role" required class="form-control">
        <option value="patient">Patient</option>
        <option value="employee">Employee</option>
        <option value="admin">Admin</option>
    </select>
                </div>
                <div class="d-grid">
                 <button type="submit" class="task-btn" >Register</button>
                </div>
                @if($errors->any())
    <div class="text-red-500 mb-2">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

          </form>
     </div>
    
@endsection