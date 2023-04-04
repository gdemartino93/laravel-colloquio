<div class="container">
  <div class="row">
    <div class="col-12 col-md-6 my-3 mx-auto d-flex align-items-center">
      <input type="text" name="search" class="form-control" wire:model="search">
    </div>
  </div>
  @if(count($this->users) > 0)
    <div class="row mt-3">
      <div class="col-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col-12">Nome</th>
              <th scope="col-12">Email</th>
              <th scope="col-12">Città</th>
              <th scope="col-12">Tag</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($this->users as $user)
              <tr>
                <td class="fw-bold">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->city }}</td>
                @if($user->tag->isEmpty())
                  <td>//</td>
                @else
                  @foreach($user->tag as $tag)
                    <td class="d-flex flex-column" >{{ $tag->name }}</td>
                  @endforeach
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @else
    <div class="row mt-3">
      <div class="col-12">
        <h1 class="text-danger">Nessun risultato</h1>
      </div>
    </div>
  @endif

  <div class="row mt-3">
    <div class="col-12">
      {!! $users->links() !!}
    </div>
  </div>
</div>
