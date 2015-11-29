</main>
<footer>
    <hr>
</footer>
</body>

<script type="text/javascript">
    $(document).on('click', '.date-picker', function (e) {
        var date = new Date();
        var tomorrow = new Date(date.getTime() + 24 * 60 * 60 * 1000);
        $(this).datetimepicker({
            minDate: tomorrow,
            sideBySide: true,
            showClear: true,
            format: 'YYYY-MM-DD HH:mm'
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        var date = new Date();

        var start = $('#start-time-picker');
        var end = $('#end-time-picker');

        start.datetimepicker({
            minDate: date,
            useCurrent: false,
            sideBySide: true,
            showClear: true,
            format: 'YYYY-MM-DD HH:mm'
        });

        end.datetimepicker({
            useCurrent: false, //Important! See issue #1075
            sideBySide: true,
            showClear: true,
            format: 'YYYY-MM-DD HH:mm'
        });
        start.on("dp.change", function (e) {
            end.data("DateTimePicker").minDate(e.date);
        });
        end.on("dp.change", function (e) {
            start.data("DateTimePicker").maxDate(e.date);
        });
    });
</script>

