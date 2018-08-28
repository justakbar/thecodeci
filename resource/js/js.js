jQuery(function($){

	$('#invisibile, #visibile').click(function() {
		var a = $(this).attr('name');
		var length = a.length;
		if (a == 'visibile_' + a[length-1]) {
			id = a[length - 1];
			type = '0';
		} else if (a == 'invisibile_' + a[length-1]) {
			id = a[length - 1];
			type = '1';
		}

		$.ajax({
			url: location.href,
			type: 'post',
			data: {'id':id, 'type': type},
			success: function() {
				if (a == 'visibile_' + id) {
					$('#icon'+ id).attr('class','fas fa-eye');
					$('button[name="' + a + '"]').attr('name','invisibile_' + id);
					$('button[name="' + a + '"]').attr('id','invisibile');
				}
				else if (a == 'invisibile_' + id) {
					$('#icon' + id).attr('class', 'fas fa-eye-slash');
					$('button[name="' + a + '"]').attr('name','visibile_' + id);
					$('button[name="' + a + '"]').attr('id','visibile');
				}
			}
		});
	});

	/*$('#delete').click(function() {
		var a = $(this).attr('name');
		var length = a.length;
		if (a == 'delete_' + a[length-1]) {
			id = a[length - 1];
			query = 'delete';
		}
		alert(id);
		$.ajax({
			url: location.href,
			type: 'post',
			data: {'id' : id, 'query' : query},
			success: function() {
				$('#accordion_' + id).remove();
			}
		})


	});*/

	$('#voteup').click(function () {
		$.ajax({
			url: location.href,
			type: 'post',
			data: {'query': 'voteup'},
			success: function () {
				$('#voteup').attr('disabled','disabled');
				$('#votedown').removeAttr('disabled');
				$('#rating').text(parseInt($('#rating').text()) + 1);
			}
		})
	});
	$('#votedown').click(function () {
		$.ajax({
			url: location.href,
			type: 'post',
			data: {'query': 'votedown'},
			success: function () {
				$('#votedown').attr('disabled','disabled');
				$('#voteup').removeAttr('disabled');
				$('#rating').text(parseInt($('#rating').text()) - 1);
			}
		})
	});
});