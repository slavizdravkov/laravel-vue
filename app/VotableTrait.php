<?php


namespace App;


trait VotableTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }
}