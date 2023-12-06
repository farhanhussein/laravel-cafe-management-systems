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

    <div style="position: relative; top: 4px; right: -150px">
        <form action="{{url('/uploadfood')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div>
                <label for="id">ID</label>
                <input style="color: black" type="number" name="id" placeholder="Enter ID (optional)">
            </div>
            <div>
                <label for="">Title</label>
                <input style="color: black" type="text" name="title" placeholder="Write a title" required>
            </div>

            <div>
                <label for="">Price</label>
                <input style="color: black" type="number" name="price" placeholder="Price" required>
            </div>

            <div>
                <label for="">Image</label>
                <input style="color: black" type="file" name="image" required>
            </div>

            <div>
                <label for="">Description</label>
                <input style="color: black" type="text" name="description" placeholder="Description" required>
            </div>

            <div>
                <input type="submit" value="Save">
            </div>
        </form>

        <div>
          <table bgcolor="black">
            <tr>
              <th style="padding: 30px">Id</th>
              <th style="padding: 30px">Food Name</th>
              <th style="padding: 30px">Price</th>
              <th style="padding: 30px">Description</th>
              <th style="padding: 30px">Image</th>
              <th style="padding: 30px">Action</th>
              <th style="padding: 30px">Action 2</th>
              <th style="padding: 30px">Action 3</th>
            </tr>

            @foreach($data as $data)
              @if(!$data->deleted_at)
                <tr align="center">
                  <td>{{$data->id}}</td>
                  <td>{{$data->title}}</td>
                  <td>{{$data->price}}</td>
                  <td>{{$data->description}}</td>
                  <td><img height="200px" width="200px" src="/foodimage/{{$data->image}}"></td>
                  <td><a href="{{url('/deletemenu', $data->id)}}">Delete</a></td>
                  <td><a href="{{url('/updateview', $data->id)}}">Update</a></td>
                  <td><a href="{{url('/softDeleteMenu', $data->id)}}">Soft Del</a></td>
                </tr>
              @endif

            @endforeach
          </table>
        </div>
    </div>
  </div>

    @include("admin.adminscript")

  </body>
</html>