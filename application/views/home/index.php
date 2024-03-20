<div id="dashboardDiv"></div>
<script>
    loadlist();
    function loadlist() {

        $.ajax({
            url: 'home/getDashboard',
            method: 'post',
            data: {
                a_id: $('#a_id').val(),
                start_year: $('#start_year').val(),
                type: $('#type').val()
            }
        }).done(function(returnedData) {
            $('#dashboardDiv').html(returnedData.html);
        })
    }
    function changeApartment() {
        loadlist();
    }

    function changeLineChart() {
        loadlist();
    }
</script>