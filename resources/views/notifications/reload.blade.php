{{-- STR JS --}}

@if(Auth::guard('admin')->check())
  <input id='userUrl' type="hidden" value="{{url('admin/notifications/get_new_Notif')}}">
@else
  <input id='userUrl' type="hidden" value="{{url('notifications/get_new_Notif')}}">
@endif

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(setInterval(function() {

            $.ajax({
                url: document.getElementById('userUrl').value,
                method: 'get',
                success: (response) => {
                    //console.log(response);
                    var table = document.getElementById("reload");
                    var row = table.insertRow(0);
                    response.newNots.forEach(insert_row);
                    function insert_row(item) {
                        row.insertCell(0).innerHTML = item['message'] + ' <span class="note1x">(new)</span>';
                        row.insertCell(1).innerHTML = item['created_at'];
                        row.cells[0].className  = "float-left";
                        row.cells[1].className  = "float-right";
                    }
                },
                error: (error)=>{
                    console.log(error);
                }
            });
        },1000 * 60 * 1)); //Check The DB every 1 min
    });
</script>
{{-- END JS --}}
