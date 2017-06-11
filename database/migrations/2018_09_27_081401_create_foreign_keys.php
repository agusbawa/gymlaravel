<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('permission_role', function(Blueprint $table) {
			$table->foreign('permission_id')->references('id')->on('permissions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('permission_role', function(Blueprint $table) {
			$table->foreign('role_id')->references('id')->on('roles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('role_user', function(Blueprint $table) {
			$table->foreign('role_id')->references('id')->on('roles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('role_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		
		Schema::table('members', function(Blueprint $table) {
			$table->foreign('package_id')->references('id')->on('packages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		
		Schema::table('members', function(Blueprint $table) {
			$table->foreign('gym_id')->references('id')->on('gyms')
						->onDelete('restrict')
						->onUpdate('restrict');
		});

		Schema::table('member_options', function(Blueprint $table) {
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		
		Schema::table('gyms', function(Blueprint $table) {
			$table->foreign('zona_id')->references('id')->on('zonas')
						->onDelete('restrict')
						->onUpdate('restrict');
		});

		Schema::table('gym_user', function(Blueprint $table) {
			$table->foreign('gym_id')->references('id')->on('gyms')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('gym_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('package_prices', function(Blueprint $table) {
			$table->foreign('package_id')->references('id')->on('packages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('gym_id')->references('id')->on('gyms')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('package_price_id')->references('id')->on('packages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('promo_id')->references('id')->on('promos')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('attendances', function(Blueprint $table) {
			$table->foreign('gym_id')->references('id')->on('gyms')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('attendances', function(Blueprint $table) {
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('vote_items', function(Blueprint $table) {
			$table->foreign('vote_id')->references('id')->on('votes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('member_vote', function(Blueprint $table) {
			$table->foreign('vote_item_id')->references('id')->on('vote_items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('member_vote', function(Blueprint $table) {
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		
		Schema::table('agenda_participant', function(Blueprint $table) {
			$table->foreign('agenda_id')->references('id')->on('agendas')
						->onDelete('restrict')
						->onUpdate('restrict');
		});

		Schema::table('card_member', function(Blueprint $table) {
			$table->foreign('card_id')->references('id')->on('cards')
						->onDelete('restrict')
						->onUpdate('restrict');
						
			$table->foreign('member_id')->references('id')->on('members')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('permission_role', function(Blueprint $table) {
			$table->dropForeign('permission_role_permission_id_foreign');
		});
		Schema::table('permission_role', function(Blueprint $table) {
			$table->dropForeign('permission_role_role_id_foreign');
		});
		Schema::table('role_user', function(Blueprint $table) {
			$table->dropForeign('role_user_role_id_foreign');
		});
		Schema::table('role_user', function(Blueprint $table) {
			$table->dropForeign('role_user_user_id_foreign');
		});
		
		Schema::table('members', function(Blueprint $table) {
			$table->dropForeign('members_package_id_foreign');
		});
		Schema::table('members', function(Blueprint $table) {
			$table->dropForeign('members_gym_id_foreign');
		});
		Schema::table('gym_user', function(Blueprint $table) {
			$table->dropForeign('gym_user_gym_id_foreign');
		});
		Schema::table('gym_user', function(Blueprint $table) {
			$table->dropForeign('gym_user_user_id_foreign');
		});
		Schema::table('package_prices', function(Blueprint $table) {
			$table->dropForeign('package_prices_package_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_gym_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_package_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_member_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_promo_id_foreign');
		});
		Schema::table('attendances', function(Blueprint $table) {
			$table->dropForeign('attendances_gym_id_foreign');
		});
		Schema::table('attendances', function(Blueprint $table) {
			$table->dropForeign('attendances_member_id_foreign');
		});
		Schema::table('vote_items', function(Blueprint $table) {
			$table->dropForeign('vote_items_vote_id_foreign');
		});
		Schema::table('member_vote', function(Blueprint $table) {
			$table->dropForeign('member_vote_vote_item_id_foreign');
		});
		Schema::table('member_vote', function(Blueprint $table) {
			$table->dropForeign('member_vote_member_id_foreign');
		});
		
		Schema::table('agenda_participant', function(Blueprint $table) {
			$table->dropForeign('agenda_participant_agenda_id_foreign');
		});
		Schema::table('card_member', function(Blueprint $table) {
			$table->dropForeign('card_member_card_id_foreign');
		});
		Schema::table('card_member', function(Blueprint $table) {
			$table->dropForeign('card_member_member_id_foreign');
		});
	}
}