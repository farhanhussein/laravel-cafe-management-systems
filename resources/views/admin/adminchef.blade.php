<x-app-layout>

</x-app-layout>

<!DOCTYPE html>
<html lang="en">
  <head>
    @include("admin.admincss")
  </head>
  <body>

    <div class="container-scroller">
      @include("admin.navbar")

      <form action="{{url('/uploadchef')}}" method="Post" enctype="multipart/form-data">

        @csrf
        <div>
          <label for="">Name</label>
          <input style="color: black;" type="text" name="name" required="" placeholder="Enter name">
        </div>

        <div>
          <label for="">Speciality</label>
          <input style="color: black;" type="text" name="speciality" required="" placeholder="Enter the speciality">
        </div>

        <div>
        
          <input type="file" name="image" required="" placeholder="Enter the speciality">
        </div>

        <div>
          <input type="submit" value="Save">
        </div>

      </form>

      <div>
        <table bgcolor="black">
          <tr>
            <th style="padding: 30px;">Chef Name</th>
            <th style="padding: 30px;">Speciality</th>
            <th style="padding: 30px;">Image</th>
            <th style="padding: 30px;">Action</th>
            <th style="padding: 30px;">Action 2</th>
            <th style="padding: 30px;">Action 3</th>
          </tr>
          
          @foreach($data as $data)
            @if(!$data->deleted_at)
              <tr align="center">
                <td>{{$data->name}}</td>
                <td>{{$data->speciality}}</td>
                <td><img height="200" width="200" src="/chefimage/{{$data->image}}" alt=""></td>
                <td><a href="{{url('/updatechef', $data->id)}}">Update</a></td>
                <td><a href="{{url('/deletechef', $data->id)}}">Delete</a></td>
                <td><a href="{{url('/softDeleteChef', $data->id)}}">Soft Del</a></td>
              </tr>
            @endif
          @endforeach

        </table>
      </div>
    </div>
    
    @include("admin.adminscript")

  </body>
</html>