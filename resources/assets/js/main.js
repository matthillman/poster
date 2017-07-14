"use strict";

const $ = require('jquery');
const sortable = require('html5-sortable');
// var dialog = require('dialog-polyfill');

$(document).ready(function() {
	function bindSortable() {
		if ($(this).data('unbind')) {
			($(this).data('unbind').destroy || function() {})();
		}

		var $target = $('#' + $(this).attr('e-sortable'));

		function resetModel(sortable) {
			var $sorted = $(sortable).children();
			$sorted.each(function(index, element) {
				$(element).attr('rank', index + 1);
			});
			var order = $sorted.toArray().map(function(current) {
				return $(current).attr('member-id');
			});

			$target.val(order.join(';'));
		}

		var destroy = sortable({
			els: $(this).children(),
			type: 'insert',
			onDragEnd: function(e) { resetModel($(e.target).parent('.sortable')); }
		});

		$(this).data('unbind', destroy);

		function doEdit(e) {
			e.stopImmediatePropagation();
			var $this = $(this);
			$this.off('click.edit', doEdit);
			var value = $this.text();
			$this.text('');
			var input = $('<input type="text" class="inline">').val(value).attr('size', 20);
			var removeButton = $('<button>remove_circle</button>').addClass('delete-row material-icons').on('click', function(e) {
				e.preventDefault();
				var $parent = $(this).parent('.sortable');
				$('#member-' + $this.attr('member-id')).remove();
				$(this).parent().remove();
				$this.on('click.edit', doEdit);
				$(document).off('click.removeInput');
				resetModel($parent);
			});

			function saveChanges() {
				$this.text(input.remove().val());
				$('#member-' + $this.attr('member-id')).val([$this.attr('member-id'), $this.text()].join(';'));
				$this.on('click.edit', doEdit);
				$(document).off('click.removeInput');
			}
			input.appendTo($this).focus().on('keydown', function(e) {
				if (e.which == 13) {
					e.preventDefault();
					saveChanges();
				}
			});
			removeButton.insertAfter(input);
			$(document).on('click.removeInput', function(e) {
				if (e.target == removeButton || e.target == input) {
					return;
				}
				saveChanges();
			});
		}
		$(this).children().off('click.edit', doEdit).on('click.edit', doEdit);
	}
	$('[e-sortable]').each(bindSortable);

	$('[e-add-row]').on('click.addRow', function() {
		var $sortable = $(this).parent().siblings('.sortable');
		var rank = $sortable.children().length + 1;
		var memberId = '__' + rank;
		var newRow = $('<div class="mdl-list__item mdl-list__item-primary-content"/>').attr({
			rank: rank,
			'member-id': memberId
		}).text('New Member');
		var newInput = $('<input type="hidden" name="members[]">').prop('id', 'member-' + memberId).attr('value', [memberId, 'New Member'].join(';'));
		$sortable.append(newRow);
		$(this).parent().siblings('input[type=hidden]').last().after(newInput);
		bindSortable.call($sortable.get());

		setTimeout(function() {
			newRow.trigger('click');
			newRow.find('input').select();
		}, 1);
	});

	$('[e-filltext]').on('click.filltext', function() {
		$('#' + $(this).attr('e-filltext'))
			.focus()
			.val($(this).text())
			.addClass('mdl-textfield__input is-dirty')
			.parents('.mdl-textfield')
			.addClass('is-dirty');
	});

	$('[e-select-timezone]').on('click.timezone', function() {
		$('#' + $(this).attr('e-select-timezone'))
			.val($(this).text())
			.addClass('mdl-textfield__input is-dirty')
			.parents('.mdl-textfield')
			.addClass('is-dirty');
	});

	$('[e-go]').on('click.go', function() {
		window.location.assign($(this).attr('e-go'));
	});

	$('[e-input-array]').each(function() {
		var name = $(this).attr('name');
		var $container = $('#' + $(this).attr('e-input-array'));

		$(this).find(':checkbox').on('change.array', function() {
			var value = $(this).attr('value');

			if (this.checked) {
				$('<input type="hidden"/>')
					.attr('name', name + '[]')
					.attr('value', value)
					.appendTo($container);
			} else {
				$container.find('[value=' + value + ']').remove();
			}
		});
	});

	$('[e-disable-related]').on('change.disable', function() {
		var checked = this.checked;
		$(this).attr('e-disable-related').split('|').forEach(function(id) {
			$('#' + id).val('').prop('disabled', checked).parent('.is-dirty').removeClass('is-dirty');
		});
	});

	// $('dialog').each(function() {
	// 	dialog.registerDialog(this);
	// });

});
