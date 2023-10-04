<!-- BEGIN: Dark Mode Switcher-->
<div data-url="side-menu-dark-dashboard-overview-2.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
    <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>
    <div class="dark-mode-switcher__toggle border"></div>
</div>
<!-- END: Dark Mode Switcher-->

<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
<script src="{{asset('adminpanel/js/app.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
        $(document).ready(function() {
        // Event listener for the first select element
            $('#dropdown1').val(63);
        $('#dropdown1').change(function() {
            var parentId = $(this).val();

            if (parentId) {
                // Make an AJAX request to fetch the zones based on the selected parent zone
                $.ajax({
                    url: "{{ url('admin/dropdown1')}}",
                    type: "GET",
                    data: { parent_id: parentId },
                    success: function(response) {

                        // Update the options of the second select element
                        $('#dropdown2').html('<option value="">Select Zone 2</option>');
                        $.each(response, function(key, zone) {
                            console.log(zone.title)
                            $('#dropdown2').append('<option value="' + zone.id + '">' + zone.title + '</option>');
                        });
                    }
                });
            } else {
                // Reset the second and third select elements if the first select element is changed back to the default option
                $('#dropdown2').html('<option value="">Select Zone 2</option>');
                $('#dropdown3').html('<option value="">Select Zone 3</option>');
            }
        });
        });
        // Event listener for the second select element

        $('#dropdown2').change(function() {
        var parentId = $(this).val();
        if (parentId) {
        // Make an AJAX request to fetch the zones based on the selected parent zone
        $.ajax({
         url: '/dropdown2/'+ parentId  ,
        type: "GET",
        data: { parent_id: parentId },
        success: function(response) {
        // Update the options of the third select element
        $('#dropdown3').html('<option value="">Select Zone 3</option>');
        $.each(response, function(key, zone) {
        $('#dropdown3').append('<option value="' + zone.id + '">' + zone.name + '</option>');
    });
    }
    });
    } else {
        // Reset the third select element if the second select element is changed back to the default option
        $('#zone3').html('<option value="">Select Zone 3</option>');
    }
    });

            $( function() {
            $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );


</script>
{{--    $(document).ready(function() {--}}
{{--        // Handle category change event--}}
{{--        $('#dropdown1').change(function() {--}}
{{--            var categoryId = $(this).val();--}}
{{--            var subcategoryDropdown = $('#dropdown2');--}}

{{--            // Clear existing options--}}
{{--            subcategoryDropdown.empty();--}}

{{--            // Add default option--}}
{{--            subcategoryDropdown.append('<option value="">Select Subcategory</option>');--}}

{{--            // Make AJAX request to retrieve subcategory options--}}
{{--            if (categoryId) {--}}
{{--                $.ajax({--}}
{{--                    url: '/dropdown2/'+categoryId, // Replace with your server endpoint--}}
{{--                    method: 'GET',--}}
{{--                    data: { categoryId: categoryId },--}}
{{--                    success: function(response) {--}}
{{--                        // Add subcategory options based on the AJAX response--}}
{{--                        $.each(response.categoryId, function(index, value) {--}}
{{--                            alert(value);--}}
{{--                            subcategoryDropdown.append('<option value="' + value + '">' + value + '</option>');--}}
{{--                        });--}}
{{--                    },--}}
{{--                    error: function() {--}}
{{--                        console.log('Error occurred while retrieving subcategories.');--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}

<script>
    $(document).ready(function() {
        $('.checkboxId').change(function() {
            var checkboxValue = $(this).is(':checked')? 1 : 0;;
            var ctegoryId = $(this).data('category-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('checkbox.update') }}',
                type: 'GET',
                data: {
                    checkboxValue: checkboxValue,
                    ctegoryId: ctegoryId
                },
                success: function(response) {
                    console.log('Checkbox updated successfully');
                },
                error: function(xhr) {
                    console.log('Error updating checkbox');
                }
            });
        });
    });
</script>

<!-- END: JS Assets-->
</body>
</html>
