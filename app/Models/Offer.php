<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Offer
 *
 * @package App\Models
 *
 * @property integer    $id
 * @property string     $slug
 * @property integer    $owner_id
 * @property integer    $type_id
 * @property string     $title
 * @property string     $sub_title
 * @property string     $description
 * @property array      $meta
 * @property User       $owner
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 *
 * @property Collection $addresses
 * @property Collection $reviews
 * @property Collection $gallery
 * @property Collection $prices
 * @property Collection $transactions
 * @property OfferType  $type
 */
class Offer extends Model
{
	use SlugTrait;

	protected $with = ['addresses'];

	protected $casts = [
		'meta'         => 'array',
		'geo_location' => 'array',
	];

	protected $fillable = [
		'owner_id',
		'title',
		'sub_title',
		'address_id',
		'description',
		'geo_location',
		'meta',
		'type_id',
		'slug',
	];

	protected $hidden = [
		'deleted_at',
		'updated_at',
	];

	protected $appends = [
		'creator',
		'type',
	];

	public function getRouteKeyName()
	{
		return 'slug';
	}

	public function getCreatorAttribute(): string
	{
		return $this->owner->name;
	}

	public function owner(): Relation
	{
		return $this->belongsTo(User::class, 'owner_id');
	}

	public function addresses(): Relation
	{
		return $this->morphToMany(
			Address::class,
			'addressable',
			'addressables'
		);
	}

	public function images(): Relation
	{
		return $this->morphToMany(
			Image::class,
			'relation',
			'gallery'
		);
	}

	public function offerType(): Relation
	{
		return $this->belongsTo(OfferType::class, 'type_id');
	}

	public function getTypeAttribute(): string
	{
		if (!$this->offerType()->first() instanceof OfferType) {
			return 'unknown';
		}
		return $this->offerType()->first()->type;
	}

	public function articles()
	{
		return $this->morphToMany(
			Article::class,
			'element',
			'elements'
		);
	}

	public function reviews(): Relation
	{
		return $this->morphMany(
			Review::class,
			'reviewed'
		);
	}

	public function prices(): Relation
	{
		return $this->morphOne(
			Price::class,
			'priceable'
		);
	}

	public function gallery(): Relation
	{
		return $this->morphToMany(
			Image::class,
			'relation',
			'gallery'
		);
	}

	public function transactions(): Relation
	{
		return $this->morphMany(
			Transaction::class,
			'paid_for'
		);
	}
}
