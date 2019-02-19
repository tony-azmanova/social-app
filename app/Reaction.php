<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{

    protected $fillable = [
        'user_id',
        'element_type',
        'element_id',
        'reaction_type',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning reactable models.
     */
    public function reactable()
    {
        return $this->morphTo();
    }

    /**
     * Create or delete reaction 
     * 
     * @param type $elementType
     */
    public static function createOrDelete($elementType, $elementId, $type = 'like')
    {
        $reaction = $elementType::find($elementId)
            ->reactions()
            ->where('user_id', auth()->id())
            ->where('element_type', $elementType)->get()->first();

        if ($reaction) {
            $reaction->delete();
            return false;
        }

        return boolval(Reaction::create([
            'user_id' =>  auth()->id(),
            'element_type' => $elementType,
            'element_id' => $elementId,
            'reaction_type' => $type
        ]));
    }
    
    /**
     * Check if user has liked the type. Returns true if user has liked type.
     * 
     * @param type $elementType
     * @param type $elementId
     * @return type
     */
    public static function isUserReactedToType($elementType, $elementId)
    {
        $result = Reaction::where('reactions.user_id', auth()->id())
             ->where('reactions.element_id', $elementId)
             ->where('reactions.element_type', $elementType);

        return boolval($result->get()->isNotEmpty());
    }
}
