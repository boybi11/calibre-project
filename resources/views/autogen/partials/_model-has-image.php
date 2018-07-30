	public function asset()
	{
		return $this->hasOne('App\Asset', 'id', 'image');
	}