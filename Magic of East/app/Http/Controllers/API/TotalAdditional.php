<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\total_additional;
use App\Trait\ApiResponse;
use Throwable;
use Exception;

class TotalAdditional extends Controller
{
    use ApiResponse;
    public function destroy($id)
    {
        try {
            $t = total_additional::find($id);
            if ($t == null) throw new Exception('No such Record', 404);
            $t->delete();
            return $this->SuccessOne(null, null, 'Total_Additional deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }
}