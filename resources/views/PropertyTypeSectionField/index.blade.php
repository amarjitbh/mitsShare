
@extends ('layouts.master')

@section('content')
    <h1 class="text-center">Manage All Property Types</h1>
    <hr/><br/><br/>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table class="table table-bordered table-hover">
      <thead class="thead-default">
        <tr>
          <th>Serial No.</th>
          <th>Id</th>
          <th>Name</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; ?>
        @foreach ($PropertyTypes as $PropertyType)
        <tr>
          <td scope="row">{{++$i}}</td>
          <td>{{$PropertyType->id}}</td>
          <td width="200px">{{$PropertyType->name}}</td>
          <td>{{$PropertyType->created_at}}</td>
          <td>{{$PropertyType->updated_at}}</td>
          <td >
          {{-- {{@url('app').'/'.$PropertyType->id}} --}}
            <p><a href="{{@url('propertytype').'/'.$PropertyType->id.'/edit'}}" class="btn btn-primary">Update</a></p>
            <form action="{{@url('propertytype').'/'.$PropertyType->id}}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger">Detete</button>
            </form>
          </td>
        </tr>
        {{-- {{$i++}} --}}
        @endforeach
      </tbody>
    </table>

       <div>
       <?php echo $PropertyTypes->links(); ?>
       </div>
@endsection
