<div id="listDiv"></div>

<script>
    loadTemplate();

    function loadTemplate() {
        $.ajax({
            url: 'addTemplate',
            method: 'post',
        }).done(function(returnedData) {
            $('#listDiv').html(returnedData.html);
        })
    }
</script>