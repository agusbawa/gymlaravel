<?php

// Home
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', route('overview.index'));
});
//tiekt support 
Breadcrumbs::register('tikketsupport', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Tiket Support', route('tiketsupport.index'));
});
Breadcrumbs::register('edit-support', function($breadcrumbs,$tiketsupport)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Tiket Support', route('tiketsupport.index',$tiketsupport));
    $breadcrumbs->push('Reply Tiket Support', route('tiketsupport.edit',$tiketsupport));
});
//email template dan list
Breadcrumbs::register('listemail', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('List Email', route('listemail.index'));
});
Breadcrumbs::register('edit-list', function($breadcrumbs,$listemail)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Edit List Email', route('listemail.edit',$listemail));
});
Breadcrumbs::register('create-list', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('List Email', route('listemail.index'));
    $breadcrumbs->push('Tambah List Email', route('listemail.create'));
});
Breadcrumbs::register('templateemail', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Templates Email', route('templateemail.index'));
});
Breadcrumbs::register('edit-templateemail', function($breadcrumbs,$template)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Templates Email', route('templateemail.index'));
    $breadcrumbs->push('Edit Templates Email', route('templateemail.edit',$template));
});

// Gym Breadcrumbs
Breadcrumbs::register('zona', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Zona', route('zonas.index'));
});

Breadcrumbs::register('zona-create', function($breadcrumbs)
{
    $breadcrumbs->parent('zona');
    $breadcrumbs->push('Tambah', route('zonas.create'));
});

Breadcrumbs::register('zona-show', function($breadcrumbs, $zona)
{
    $breadcrumbs->parent('zona');
    $breadcrumbs->push($zona->title, route('zonas.show', $zona->id));
});

Breadcrumbs::register('zona-edit', function($breadcrumbs, $zona)
{
    $breadcrumbs->parent('zona');
    $breadcrumbs->push($zona->title, route('zonas.show', $zona->id));
    $breadcrumbs->push('Edit', route('zonas.edit', $zona->id));
});

// Gym Breadcrumbs
Breadcrumbs::register('gym', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Gym', route('gyms.index'));
});

Breadcrumbs::register('gym-create', function($breadcrumbs)
{
    $breadcrumbs->parent('gym');
    $breadcrumbs->push('Tambah', route('gyms.create'));
});

Breadcrumbs::register('gym-show', function($breadcrumbs, $gym)
{
    $breadcrumbs->parent('gym');
    $breadcrumbs->push($gym->title, route('gyms.show', $gym->id));
});

Breadcrumbs::register('gym-edit', function($breadcrumbs, $gym)
{
    $breadcrumbs->parent('gym');
    $breadcrumbs->push($gym->title, route('gyms.show', $gym->id));
    $breadcrumbs->push('Edit', route('gyms.edit', $gym->id));
});

// End Of Gym Breadcrumbs

// --------------------------------------------------------------------------
// Member Breadcrumbs

Breadcrumbs::register('member', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Member', route('members.index'));
});
Breadcrumbs::register('aktifasi', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Aktivasi', url('/u/members/activate'));
});
Breadcrumbs::register('member-aktifasi', function($breadcrumbs)
{
    $breadcrumbs->parent('aktifasi');
    $breadcrumbs->push('Verifikasi', route('attendances.index'));
});
Breadcrumbs::register('member-attendance', function($breadcrumbs)
{
    $breadcrumbs->parent('member');
    $breadcrumbs->push('Absensi', route('attendances.index'));
});

Breadcrumbs::register('member-attendance-upload', function($breadcrumbs)
{
    $breadcrumbs->parent('member-attendance');
    $breadcrumbs->push('Upload', '');
});

Breadcrumbs::register('member-create', function($breadcrumbs)
{
    $breadcrumbs->parent('member');
    $breadcrumbs->push('Tambah', route('members.create'));
});

Breadcrumbs::register('member-upload', function($breadcrumbs)
{
    $breadcrumbs->parent('member');
    $breadcrumbs->push('Upload', route('members.upload'));
});

Breadcrumbs::register('member-show', function($breadcrumbs, $member)
{
    $breadcrumbs->parent('member');
    $breadcrumbs->push($member->name, route('members.show', $member->id));
});

Breadcrumbs::register('member-edit', function($breadcrumbs, $member)
{
    $breadcrumbs->parent('member');
    $breadcrumbs->push($member->name, route('members.show', $member->id));
    $breadcrumbs->push('Edit', route('members.edit', $member->id));
});

Breadcrumbs::register('member-extend', function($breadcrumbs, $member)
{
    $breadcrumbs->parent('member');
    $breadcrumbs->push($member->name, route('members.show', $member->id));
    $breadcrumbs->push('Perpanjang', '');
});

// End Of Member Breadcrumbs

// --------------------------------------------------------------------------
// News Breadcrumbs
Breadcrumbs::register('news', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('News', route('news.index'));
});

Breadcrumbs::register('news-create', function($breadcrumbs)
{
    $breadcrumbs->parent('news');
    $breadcrumbs->push('Tambah', route('news.create'));
});

Breadcrumbs::register('news-show', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('news');
    $breadcrumbs->push($news->name, route('news.show', $news->id));
});

Breadcrumbs::register('news-edit', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('news');
    $breadcrumbs->push($news->title, route('news.show', $news->id));
    $breadcrumbs->push('Edit', route('news.edit', $news->id));
});

// End Of News Breadcrumbs

// --------------------------------------------------------------------------
// Card Breadcrumbs
Breadcrumbs::register('card', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Kartu', route('cards.index'));
});

Breadcrumbs::register('card-create', function($breadcrumbs)
{
    $breadcrumbs->parent('card');
    $breadcrumbs->push('Tambah', route('cards.create'));
});

Breadcrumbs::register('card-show', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('card');
    $breadcrumbs->push($news->name, route('cards.show', $news->id));
});

Breadcrumbs::register('card-edit', function($breadcrumbs, $news)
{
    $breadcrumbs->parent('card');
    $breadcrumbs->push($news->title, route('cards.show', $news->id));
    $breadcrumbs->push('Edit', route('cards.edit', $news->id));
});

// --------------------------------------------------------------------------
// Promo Breadcrumbs
Breadcrumbs::register('promo', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Code Promo', route('promos.index'));
});

Breadcrumbs::register('promo-create', function($breadcrumbs)
{
    $breadcrumbs->parent('promo');
    $breadcrumbs->push('Tambah Code Promo', route('promos.create'));
});

Breadcrumbs::register('promo-show', function($breadcrumbs, $promo)
{
    $breadcrumbs->parent('promo');
    $breadcrumbs->push($promo->name, route('promos.show', $promo->id));
});

Breadcrumbs::register('promo-edit', function($breadcrumbs, $promo)
{
    $breadcrumbs->parent('promo');
    $breadcrumbs->push($promo->title, route('promos.show', $promo->id));
    $breadcrumbs->push('Edit Code Promo', route('promos.edit', $promo->id));
});

// End Of vote Breadcrumbs

// --------------------------------------------------------------------------
// vote Breadcrumbs
Breadcrumbs::register('poolings', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Poolings', route('poolings.index'));
});

Breadcrumbs::register('poolings-create', function($breadcrumbs)
{
    $breadcrumbs->parent('poolings');
    $breadcrumbs->push('Tambah', route('poolings.create'));
});
Breadcrumbs::register('poolings-show', function($breadcrumbs,$pooling)
{
    $breadcrumbs->parent('poolings');
    
    $breadcrumbs->push('Lihat Pooling', route('poolings.show',$pooling));
});

//Breadcrumbs::register('promo-show', function($breadcrumbs, $promo)
//{
//    $breadcrumbs->parent('promo');
//    $breadcrumbs->push($promo->name, route('promos.show', $promo->id));
//});
//
Breadcrumbs::register('poolings-edit', function($breadcrumbs, $vote)
{
    $breadcrumbs->parent('poolings');
    $breadcrumbs->push($vote->title, route('poolings.show', $vote->id));
    $breadcrumbs->push('Edit', route('poolings.edit', $vote->id));
});

// End Of vote Breadcrumbs

// --------------------------------------------------------------------------
// Packages Breadcrumbs
Breadcrumbs::register('package', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Kategori Harga', route('packages.index'));
});

Breadcrumbs::register('package-create', function($breadcrumbs)
{
    $breadcrumbs->parent('package');
    $breadcrumbs->push('Tambah', route('packages.create'));
});

Breadcrumbs::register('package-show', function($breadcrumbs, $package)
{
    $breadcrumbs->parent('package');
    $breadcrumbs->push($package->title, route('packages.show', $package->id));
});

Breadcrumbs::register('package-edit', function($breadcrumbs, $package)
{
    $breadcrumbs->parent('package');
    $breadcrumbs->push($package->title, route('packages.show', $package->id));
    $breadcrumbs->push('Edit', route('packages.edit', $package->id));
});

// End Of Packages Breadcrumbs

// --------------------------------------------------------------------------
// Packages list Breadcrumbs
Breadcrumbs::register('packagelist', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('List harga', route('packageprices.index'));
});

Breadcrumbs::register('packagelist-create', function($breadcrumbs)
{
    $breadcrumbs->parent('packagelist');
    $breadcrumbs->push('Tambah', route('packages.create'));
});
//
//Breadcrumbs::register('package-show', function($breadcrumbs, $package)
//{
//    $breadcrumbs->parent('package');
//    $breadcrumbs->push($package->title, route('packages.show', $package->id));
//});
//
Breadcrumbs::register('packagelist-edit', function($breadcrumbs, $package)
{
    $breadcrumbs->parent('packagelist');
    
    $breadcrumbs->push('Edit', route('packages.edit', $package->id));
});

// End Of Packages Breadcrumbs

// --------------------------------------------------------------------------
// Packages Price Breadcrumbs

Breadcrumbs::register('package-price', function($breadcrumbs, $package)
{
    $breadcrumbs->parent('package-show', $package);
    $breadcrumbs->push('Harga', route('prices.index', $package->id));
});

Breadcrumbs::register('package-price-create', function($breadcrumbs, $package)
{
    $breadcrumbs->parent('package-price', $package);
    $breadcrumbs->push('Tambah', route('prices.create', $package->id));
});

Breadcrumbs::register('package-price-show', function($breadcrumbs, $package)
{
    $breadcrumbs->parent('package-price', $package);
    $breadcrumbs->push($package->title, route('prices.show', $package->id));
});

Breadcrumbs::register('package-price-edit', function($breadcrumbs, $package, $packagePrice)
{
    $breadcrumbs->parent('package-price', $package);
    $breadcrumbs->push($packagePrice->title, route('prices.show', [$package->id, $packagePrice->id]));
    $breadcrumbs->push('Edit', route('prices.edit', [$package->id, $packagePrice->id]));
});

// End Of Packages Price Breadcrumbs

// --------------------------------------------------------------------------
// Roles Breadcrumbs

Breadcrumbs::register('role', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Pengurus', route('roles.index'));
});

Breadcrumbs::register('role-create', function($breadcrumbs)
{
    $breadcrumbs->parent('role');
    $breadcrumbs->push('Tambah', route('roles.create'));
});

Breadcrumbs::register('role-edit', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('role');
    $breadcrumbs->push($user->name, route('roles.show', [$user->id]));
    $breadcrumbs->push('Edit', route('roles.edit', [$user->id]));
});

// End Of Roles Breadcrumbs

// --------------------------------------------------------------------------
// Privileges Breadcrumbs

Breadcrumbs::register('privilege', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Role', route('privileges.index'));
});

Breadcrumbs::register('privilege-create', function($breadcrumbs)
{
    $breadcrumbs->parent('privilege');
    $breadcrumbs->push('Tambah', route('privileges.create'));
});

Breadcrumbs::register('privilege-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('privilege', $role);
    $breadcrumbs->push($role->title, route('privileges.show', $role->id));
});

Breadcrumbs::register('privilege-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('privilege', $role);
    $breadcrumbs->push('Edit', route('privileges.edit', [$role->id]));
});

// End Of Privileges Breadcrumbs
// --------------------------------------------------------------------------
// Transaction Breadcrumbs

Breadcrumbs::register('transaction', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Transaksi', route('transactions.index'));
});

Breadcrumbs::register('transaction-create', function($breadcrumbs)
{
    $breadcrumbs->parent('transaction');
    $breadcrumbs->push('Tambah', route('transactions.create'));
});

Breadcrumbs::register('transaction-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('transaction', $role);
    $breadcrumbs->push($role->title, route('transactions.show', $role->id));
});

Breadcrumbs::register('transaction-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('transaction', $role);
    $breadcrumbs->push('Edit', route('transactions.edit', [$role->id]));
});

// End Of Transaction Breadcrumbs

Breadcrumbs::register('profile', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push($user->name, route('roles.index'));
});

// member Harian

Breadcrumbs::register('memberharian', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Member Gym Harian', route('gymharian.index'));
});

Breadcrumbs::register('memberharian-create', function($breadcrumbs)
{
    $breadcrumbs->parent('memberharian');
    $breadcrumbs->push('Tambah Member Harian', route('gymharian.create'));
});

Breadcrumbs::register('memberharian-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('memberharian', $role);
    $breadcrumbs->push($role->title, route('gymharian.show', $role->id));
});

Breadcrumbs::register('memberharian-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('memberharian', $role);
    $breadcrumbs->push('Edit Member Harian', route('gymharian.edit', [$role->id]));
});

// Personal Trainer

Breadcrumbs::register('personaltrainer', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Personal Trainer', route('personaltrainer.index'));
});

Breadcrumbs::register('personaltrainer-create', function($breadcrumbs)
{
    $breadcrumbs->parent('personaltrainer');
    $breadcrumbs->push('Tambah Personal Trainer', route('personaltrainer.create'));
});

Breadcrumbs::register('personaltrainer-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('personaltrainer', $role);
    $breadcrumbs->push($role->title, route('personaltrainer.show', $role->id));
});

Breadcrumbs::register('personaltrainer-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('personaltrainer', $role);
    $breadcrumbs->push('Edit Personal Trainer', route('personaltrainer.edit', [$role->id]));
});

// Kantin

Breadcrumbs::register('kantin', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Kantin', route('kantin.index'));
});

Breadcrumbs::register('kantin-create', function($breadcrumbs)
{
    $breadcrumbs->parent('kantin');
    $breadcrumbs->push('Tambah Kantin', route('kantin.create'));
});

Breadcrumbs::register('kantin-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('kantin', $role);
    $breadcrumbs->push($role->title, route('kantin.show', $role->id));
});

Breadcrumbs::register('kantin-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('kantin', $role);
    $breadcrumbs->push('Edit Kantin', route('kantin.edit', [$role->id]));
});

// Petty cash

Breadcrumbs::register('pettycash', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Petty Cash', route('pettycash.index'));
});

Breadcrumbs::register('pettycash-create', function($breadcrumbs)
{
    $breadcrumbs->parent('pettycash');
    $breadcrumbs->push('Tambah Petty Cash', route('pettycash.create'));
});

Breadcrumbs::register('pettycash-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('pettycash', $role);
    $breadcrumbs->push($role->title, route('pettycash.show', $role->id));
});

Breadcrumbs::register('pettycash-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('pettycash', $role);
    $breadcrumbs->push('Edit Petty Cash', route('pettycash.edit', [$role->id]));
});

// Petty cash

Breadcrumbs::register('pengeluaran', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Pengeluaran', route('pengeluaran.index'));
});

Breadcrumbs::register('pengeluaran-create', function($breadcrumbs)
{
    $breadcrumbs->parent('pengeluaran');
    $breadcrumbs->push('Tambah Pengeluaran', route('pengeluaran.create'));
});

Breadcrumbs::register('pengeluaran-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('pengeluaran', $role);
    $breadcrumbs->push($role->title, route('pengeluaran.show', $role->id));
});

Breadcrumbs::register('pengeluaran-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('pengeluaran', $role);
    $breadcrumbs->push('Edit Pengeluaran', route('pengeluaran.edit', [$role->id]));
});

// Storan Bank

Breadcrumbs::register('storan', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Setoran Bank', route('storan.index'));
});

Breadcrumbs::register('storan-create', function($breadcrumbs)
{
    $breadcrumbs->parent('storan');
    $breadcrumbs->push('Tambah Setoran Bank', route('storan.create'));
});

Breadcrumbs::register('storan-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('storan', $role);
    $breadcrumbs->push($role->title, route('storan.show', $role->id));
});

Breadcrumbs::register('storan-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('storan', $role);
    $breadcrumbs->push('Edit Setoran Bank', route('storan.edit', [$role->id]));
});

// Trial Member

Breadcrumbs::register('trial', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Trial Member', route('trial.index'));
});

Breadcrumbs::register('trial-create', function($breadcrumbs)
{
    $breadcrumbs->parent('trial');
    $breadcrumbs->push('Tambah Trial Member', route('trial.create'));
});

Breadcrumbs::register('trial-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('trial', $role);
    $breadcrumbs->push($role->name, route('trial.show', $role->id));
});

Breadcrumbs::register('trial-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('storan', $role);
    $breadcrumbs->push('Edit Trial Member', route('trial.edit', [$role->id]));
});
Breadcrumbs::register('trial-addmember', function($breadcrumbs, $trial)
{
    $breadcrumbs->parent('trial');
    $breadcrumbs->push('Tambah Trial Member ke Member', url('/u/trialmember/addmember', $trial));
});
// event
Breadcrumbs::register('event', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Event', route('events.index'));
});

Breadcrumbs::register('event-create', function($breadcrumbs)
{
    $breadcrumbs->parent('event');
    $breadcrumbs->push('Tambah Event', route('events.create'));
});

Breadcrumbs::register('event-edit', function($breadcrumbs, $event)
{
    $breadcrumbs->parent('event', $event);
    $breadcrumbs->push('Edit Event', route('events.edit', [$event->id]));
});
// Training Schedule

Breadcrumbs::register('schedule', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Training Schedule', route('schedule.index'));
});

Breadcrumbs::register('schedule-create', function($breadcrumbs)
{
    $breadcrumbs->parent('schedule');
    $breadcrumbs->push('Tambah Training Schedule', route('schedule.create'));
});

Breadcrumbs::register('schedule-show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('schedule', $role);
    $breadcrumbs->push($role->title, route('schedule.show', $role->id));
});

Breadcrumbs::register('schedule-edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('schedule', $role);
    $breadcrumbs->push('Edit Training Schedule', route('schedule.edit', [$role->id]));
});

// Promo Info Breadcrumbs
Breadcrumbs::register('promoinfo', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Promo Info', route('promoinfo.index'));
});

Breadcrumbs::register('promoinfo-create', function($breadcrumbs)
{
    $breadcrumbs->parent('promoinfo');
    $breadcrumbs->push('Tambah', route('promoinfo.create'));
});

Breadcrumbs::register('promoinfo-show', function($breadcrumbs, $p)
{
    $breadcrumbs->parent('promoinfo');
    $breadcrumbs->push($p->name, route('promoinfo.show', $p->id));
});

Breadcrumbs::register('promoinfo-edit', function($breadcrumbs, $p)
{
    $breadcrumbs->parent('promoinfo');
    $breadcrumbs->push($p->title, route('promoinfo.show', $p->id));
    $breadcrumbs->push('Edit', route('promoinfo.edit', $p->id));
});
//Transaksi info Breadcrumbs
Breadcrumbs::register('transaksi', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('trnansaksi', route('transactions.index'));
});
Breadcrumbs::register('transaksi-edit', function($breadcrumbs,$transaction)
{
    $breadcrumbs->parent('dashboard',$transaction);
    $breadcrumbs->push('trnansaksi', route('transactions.edit',$transaction->id));
});
Breadcrumbs::register('sendemail', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Kirim Email', url('/u/mail'));
});
Breadcrumbs::register('showgym', function($breadcrumbs,$zona)
{
    $breadcrumbs->parent('zona');
    $breadcrumbs->push('showgym', url('/u/showgym',$zona));
});

Breadcrumbs::register('membership', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('membership', url('/u/report/member'));
});
Breadcrumbs::register('filter', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('filter', url('/u/report/searchmember'));
});
Breadcrumbs::register('target-gym', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Target', url('/u/target'));
});
Breadcrumbs::register('target-create', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Target', url('/u/target'));
    $breadcrumbs->push('Tambah Target', url('/u/target/create'));
});
Breadcrumbs::register('target-edit', function($breadcrumbs,$target)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Target', url('/u/target'));
    $breadcrumbs->push('Edit Target', url('/u/target/edit',$target));
});
// // Home > About
// Breadcrumbs::register('about', function($breadcrumbs)
// {
//     $breadcrumbs->parent('home');
//     $breadcrumbs->push('About', route('about'));
// });

// // Home > Blog
// Breadcrumbs::register('blog', function($breadcrumbs)
// {
//     $breadcrumbs->parent('home');
//     $breadcrumbs->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::register('category', function($breadcrumbs, $category)
// {
//     $breadcrumbs->parent('blog');
//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

// // Home > Blog > [Category] > [Page]
// Breadcrumbs::register('page', function($breadcrumbs, $page)
// {
//     $breadcrumbs->parent('category', $page->category);
//     $breadcrumbs->push($page->title, route('page', $page->id));
// });