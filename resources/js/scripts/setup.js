export const setup = {
	init() {
		let closeBtn = $('.user-profile-sidebar-close-btn');
		let sidebar = $('.user-profile-sidebar');
		$('.user-profile-sidebar-btn').on('click', () => {
			sidebar.addClass('active');
			closeBtn.addClass('active');
		});

		closeBtn.on('click', () => {
			sidebar.removeClass('active');
			closeBtn.removeClass('active');
		});
	},
}