package com.scirow.app.ui.dashboard;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class DashboardViewModel extends ViewModel {

    private final MutableLiveData<String> lastUpdate;

    public DashboardViewModel() {

        lastUpdate = new MutableLiveData<>();
    }

    public LiveData<String> getUI(){

        return lastUpdate;
    }
}