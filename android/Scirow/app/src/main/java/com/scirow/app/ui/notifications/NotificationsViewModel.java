package com.scirow.app.ui.notifications;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class NotificationsViewModel extends ViewModel {

    private final MutableLiveData<String> lastUpdate;

    public NotificationsViewModel() {

        lastUpdate = new MutableLiveData<>();
    }

    public LiveData<String> getUI(){

        return lastUpdate;
    }
}