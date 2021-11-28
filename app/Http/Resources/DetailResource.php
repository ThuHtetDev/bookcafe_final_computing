<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $countRent = \App\RentBook::where('book_id',$this->id)->where('rent_status','confirm')->where('has_return','1')->count();
        $rentLists = $this->rentBooks;
        $rentListsArray = $rentLists->where('rent_status','confirm')->where('has_return','0')->toArray();
        $isRentByMe = false;
        foreach($rentListsArray as $rent){
            if($rent['user_id'] == \Auth::user()->id){
                $isRentByMe = true;
            }
        }
        $inRentedCountByOther = $rentLists->where('has_return','0')->where('rent_status','confirm')->where('user_id','!=', \Auth::user()->id)->count();
        return [
            'id' => (string) $this->id,
            'isbn' => $this->isbn,
            'cover' => [
                [
                    'path' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->user_id."/book/front_cover/".$this->front_cover,
                    'preview' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->user_id."/book/front_cover/front_small_".substr($this->front_cover, strpos($this->front_cover, "_") + 1),
                    'name' => 'Front Cover'
                ],
                [
                    'path' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->user_id."/book/back_cover/".$this->back_cover,
                    'preview' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->user_id."/book/back_cover/back_small_".substr($this->back_cover, strpos($this->back_cover, "_") + 1),
                    'name' => 'Back Cover'
                ],
            ],
            'name' => $this->name,
            'description' => $this->description,
            'categoryName' => $this->category->name,
            'categoryId' => (string) $this->category->id,
            'rentCount' => (string) $countRent,
            'starCount' => '0',
            'status' => $this->status,
            'isInRent' => $isRentByMe == true ? '1' : '0',
            'isOwner' => $this->user_id == \Auth::user()->id ? '1' : '0',
            'isRentBook' => $inRentedCountByOther > 0 ? '1' : '0',
            'isAvailable' => $this->is_available == '1' ? '1' : '0'
        ];
    }
}
