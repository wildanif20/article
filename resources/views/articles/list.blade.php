@foreach ($articles as $item)
        <div class="card mt-5">
                <div class="card-header font-weight-bold text-uppercase">
                    {{$item->title}} <a href="{{route('Article.edit',$item->id)}}" class="badge badge-info">Edit</a>                    
                    <a href="{{route('Article.show',$item->id)}}" class="badge badge-info">Comment</a>                    
                    <form method="POST" action="{{route('Article.destroy', $item->id)}}">
                        {{ csrf_field() }}
                        {{method_field('DELETE')}}
                      {{-- <a href="{{route('Article.destroy', $item->id)}}" class="badge badge-danger">Delete</a> --}}
                      <input type="submit" value="hapus" class="btn btn-danger">
                      </form>        
                </div>
                <div class="card-body">
                  <blockquote class="blockquote mb-0">
                    <p>{{$item->content}}</p>
                    <footer class="blockquote-footer">Date :<cite title="Source Title">{{$item->created_at}}</cite></footer>
                  </blockquote>
                </div>
              </div>
        @endforeach