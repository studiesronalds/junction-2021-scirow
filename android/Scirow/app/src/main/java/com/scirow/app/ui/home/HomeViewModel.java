package com.scirow.app.ui.home;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class HomeViewModel extends ViewModel {

    private final MutableLiveData<String> lastUpdate;

    public HomeViewModel() {

        lastUpdate = new MutableLiveData<>();
    }

    public LiveData<String> getUI(){

        return lastUpdate;
    }
}