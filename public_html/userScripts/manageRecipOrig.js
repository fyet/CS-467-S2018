    function loadTable(){
        $.get('userComponents/recipTable.php', function(data){
            $('#recipTable').html(data);
        });
    }

    loadTable();
    $(document).ready(function(){
        $('#editRecipient').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var fname = button.data('f_name');
            var lname = button.data('l_name');
            var email = button.data('email');
            var jobTitle = button.data('job_title').replace(/_/g, ' ');
            var salary = button.data('salary');

            var modal = $(this);
            $('#f_nameEdit').val(fname);
            $('#l_nameEdit').val(lname);
            $('#emailEdit').val(email);
            $('#job_titleEdit').val(jobTitle);
            $('#salaryEdit').val(salary);

            modal.find('#userIDEdit').val(id).hide();

            $('#subEdit').click(function(){
                var userID = $('#userIDEdit').val();
                var fname = $('#f_nameEdit').val();
                var lname = $('#l_nameEdit').val();
                var uemail = $('#emailEdit').val();
                var ubranch = $('#branchEdit').val();
                var umanager = $('#managerEdit').val();
                var jobTitle = $('#job_titleEdit').val();
                var usalary = $('#salaryEdit').val();
                var payload = JSON.stringify({id: userID,
                                            f_name: fname,
                                            l_name: lname,
                                            email: uemail,
                                            branch_id: ubranch,
                                            manager_id: umanager,
                                            job_title: jobTitle,
                                            salary: usalary});
                $.ajax({
                    url: "postRecipMod.php",
                    type: 'PUT',
                    data: payload,
                    cache: false,
                    success: function(result){
                        $('#editRecipient').modal('hide');
                        loadTable();
                    }
                });
            });
        });
        $('#deleteRecipModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modal = $(this);
            modal.find('#recipIdDelete').val(id).hide();

            $('#subDel').click(function(){
                var id = $('#recipIdDelete').val();

                $.ajax({
                    url: 'postRecipMod.php?id=' + id,
                    type: 'DELETE',
                    cache: false,
                    success: function(result){
                        $('#deleteRecipModal').modal('hide');
                        $('#' + id).remove();
                    }
                });
            });
        });
    });