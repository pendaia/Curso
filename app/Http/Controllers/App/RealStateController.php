<?php

namespace App\Http\Controllers\App;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\RealState;

class RealStateController extends Controller
{
  private $realState;

  public function __construct(RealState $realState)
  {
    return $this->realState = $realState;
  }

  public function index()
  {
    $realState = $this->realState->paginate('10');

    return response()->json($realState, 200);
  }

  public function show($id)
  {
    try {

      $real = $this->realState->findOrFail($id);

      return response()->json([
        'data' => $real
      ], 200);
    } catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }
  }

  public function store(RealStateRequest $request)
  {
    $data = $request->all();
   
    try {
      $realstate = $this->realState->create($data);
        
      if (isset($data['categories']) && count($data['categories'])) {
        $realstate->categories()->sync($data['categories']);
      }

      return response()->json([
        'data' => [
          'msg' => 'Imóvel cadastrado com sucesso'
        ]
      ], 200);
    } catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }
  }

  public function update($id, RealStateRequest $request)
  {
    $data = $request->all();

    try {

      $real = $this->realState->findOrFail($id);
      $real->update($data);

      if (isset($data['categories']) && count($data['categories'])) {
        $real->categories()->sync($data['categories']);
      }

      return response()->json([
        'data' => [
          'msg' => 'Imóvel Atualizado com sucesso'
        ]
      ], 200);
    } catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }
  }

  public function destroy($id)
  {
    try {
      $real = $this->realState->findOrFail($id);
      $real->delete();
      return response()->json([
        'data' => [
          'msg' => 'Imóvel removido com sucesso'
        ]
      ], 200);
    } catch (\Exception $e) {
      $message = new ApiMessages($e->getMessage());
      return response()->json($message->getMessage(), 401);
    }
  }
}
