package com.scirow.app.ui.notifications;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.scirow.app.R;
import com.scirow.app.databinding.FragmentNotificationsBinding;
import com.scirow.app.ui.dashboard.DashboardViewModel;
import com.scirow.app.ui.dashboard.GridAdapter;

public class NotificationsFragment extends Fragment {

    private NotificationsViewModel notificationViewModel;
    public static View viewModal;
    Context context;

    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);

        context = getActivity();
        SharedPreferences pref = PreferenceManager.getDefaultSharedPreferences(context);
        Integer index = pref.getInt("index",40);

        // set app title
        TextView toolbar_title = (TextView) getActivity().findViewById(R.id.toolbar_title);
        toolbar_title.setText(R.string.title_notifications);

        // set app toolbar icon
        ImageView index_drop = (ImageView) getActivity().findViewById(R.id.index_drop);
        if(index_drop!=null) {
            index_drop.setImageDrawable(getResources().getDrawable(R.drawable.ic_notify));
            index_drop.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                }
            });
        }
        
        String notifications[] = {"Unusual activity detected in kitchen faucet. Too large consumption.", "Have you just washed your hands?",  "Bathroom faucet is now connected to scirow app.",
                "Your washing machine consumes too much water", "Congrats. Two days sustainability index green zone.", "Your sustainability index dropped", "Finished running? Seems like you need to drink some water.", "Problem detected with urine faucet"};

        // inflate main layout
        notificationViewModel = new ViewModelProvider(this).get(NotificationsViewModel.class);
        viewModal = inflater.inflate(R.layout.fragment_notifications, container, false);

        ListView listView = (ListView) viewModal.findViewById(R.id.notificationsView);
        ListViewAdapter customAdapter = new ListViewAdapter(context, notifications);
        listView.setAdapter(customAdapter);

        // implement setOnItemClickListener event on GridView
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                // set an Intent to Another Activity

//                Intent intent = new Intent(MainActivity.this, SecondActivity.class);
//                intent.putExtra("image", logos[position]); // put image data in Intent
//                startActivity(intent); // start Intent
            }
        });


        return viewModal;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        viewModal = null;
    }
}