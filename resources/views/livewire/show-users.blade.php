<section class="wrapper">
<div class="container">
  <div class="row">
    <div class="col-12 col-md-6 my-3 mx-auto d-flex align-items-center">
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Cerca</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" wire:model.debounce.250ms="search">
      </div>

    </div>
  </div>
  @if(count($this->users))
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
                <td>
                  @if($user->tags->isEmpty())
                    //
                  @else
                    @foreach($user->tags as $tag)
{{--                      Tailwind CSS--}}
                      <span class="px-2 py-1 inline-block bg-gray-100" >{{ $tag->name }}</span>
                      @endforeach
                  @endif
                </td>
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
      {!! $this->users->links() !!}
    </div>
  </div>
</div>
</section>
