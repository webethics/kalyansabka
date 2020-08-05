<?php

namespace App\Observers;

use App\Models\IncomeHistory;
use App\Models\Income;

class IncomeHistoryObserver
{
    /**
     * Handle the income history "created" event.
     *
     * @param  \App\Models\IncomeHistory  $incomeHistory
     * @return void
     */
    public function created(IncomeHistory $incomeHistory)
    {
        if(!empty($incomeHistory) && !empty($incomeHistory->user_id)){
            $currentBal = 0;
            /*fetch user current income*/
            $income = Income::where('user_id',$incomeHistory->user_id)->first();
            
            if(!empty($income) && !is_null($income->count()))
                $currentBal = $income->current_bal;

            /*Check mode and do cal. based on that*/
            if($incomeHistory->mode == 1)
                $currentBal += $incomeHistory->amount;
            
			if($incomeHistory->mode == 2 && $incomeHistory->status == 1)
               $currentBal -= $incomeHistory->amount;

            /*save data in db*/
            $incomeResult = Income::updateOrCreate([
                'user_id' => $incomeHistory->user_id
            ], [
                'current_bal' => $currentBal
            ]);
        }
    }

    /**
     * Handle the income history "updated" event.
     *
     * @param  \App\Models\IncomeHistory  $incomeHistory
     * @return void
     */
    public function updated(IncomeHistory $incomeHistory)
    {
        if(!empty($incomeHistory) && !empty($incomeHistory->user_id)){
            $currentBal = 0;
            /*fetch user current income*/
            $income = Income::where('user_id',$incomeHistory->user_id)->first();
            
            if(!empty($income) && !is_null($income->count()))
                $currentBal = $income->current_bal;

            /*Check mode and do cal. based on that*/
            /* if($incomeHistory->mode == 1)
                $currentBal += $incomeHistory->amount; */
            
			if($incomeHistory->mode == 2 && $incomeHistory->status == 1)
               $currentBal -= $incomeHistory->amount;

            /*save data in db*/
            $incomeResult = Income::update([
                'user_id' => $incomeHistory->user_id
            ], [
                'current_bal' => $currentBal
            ]);
        }
    }

    /**
     * Handle the income history "deleted" event.
     *
     * @param  \App\Models\IncomeHistory  $incomeHistory
     * @return void
     */
    public function deleted(IncomeHistory $incomeHistory)
    {
        //
    }

    /**
     * Handle the income history "restored" event.
     *
     * @param  \App\Models\IncomeHistory  $incomeHistory
     * @return void
     */
    public function restored(IncomeHistory $incomeHistory)
    {
        //
    }

    /**
     * Handle the income history "force deleted" event.
     *
     * @param  \App\Models\IncomeHistory  $incomeHistory
     * @return void
     */
    public function forceDeleted(IncomeHistory $incomeHistory)
    {
        //
    }
}
