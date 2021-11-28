<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!isset($this->type)) $this->type = null;
        if($this->type == 'myrentlist'){
            // ! My RentList
            $countRent = \App\RentBook::where('book_id',$this->book_id)->where('rent_status','confirm')->where('has_return','1')->count();
            $statusSwitches = [
                'confirm' => 'in_rent',
                'queue' => 'in_queue',
                'reject' => 'reject_by_admin',
                'cancel' => 'cancel_by_user'
            ];
            return [
                'id' => (string) $this->book->id,
                'isbn' => $this->book->isbn,
                'name' => $this->book->name,
                'categoryName' => $this->book->category->name,
                'categoryId' => (string) $this->book->category->id,
                'cover' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->book->user_id ."/book/front_cover/front_small_".substr($this->book->front_cover, strpos($this->book->front_cover, "_") + 1),
                'rentCount' => (string) $countRent,
                'starCount' => '0',
                'status' =>  $statusSwitches[$this->rent_status],
                'returnDate' => [
                    'start_date' => \Carbon\Carbon::parse($this->start_date)->format('Y-m-d'),
                    'end_date' => \Carbon\Carbon::parse($this->return_date)->format('Y-m-d'),
                    'since' => $this->created_at->diffForHumans()
                ],
                'isAvailable' => $this->book->is_available == '1' ? '1' : '0'
            ];
        }
        // ! Book List
        // ! My Book List
        return [
            'id' => (string) $this->id,
            'isbn' => $this->isbn,
            'name' => $this->name,
            'categoryName' => $this->category->name,
            'categoryId' => (string) $this['category']["id"],
            'cover' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->user_id."/book/front_cover/front_small_".substr($this->front_cover, strpos($this->front_cover, "_") + 1),
            'rentCount' => $this->type == 'bestrentbooks' ? (string) $this->count  : (string) \App\RentBook::where('book_id',$this->id)->where('rent_status','confirm')->where('has_return','1')->where('return_approve','1')->count(),
            'starCount' => '0',
            'status' => $this->status,
            'uploadDate' => [
                'date' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
                'since' => $this->created_at->diffForHumans()
            ],
            'isAvailable' => $this->is_available == '1' ? '1' : '0'
        ];
    }
}
