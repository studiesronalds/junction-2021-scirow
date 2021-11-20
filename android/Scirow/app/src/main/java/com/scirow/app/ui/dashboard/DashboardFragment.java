package com.scirow.app.ui.dashboard;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.browser.customtabs.CustomTabsIntent;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.scirow.app.R;
import com.scirow.app.databinding.FragmentDashboardBinding;
import com.scirow.app.ui.home.HomeViewModel;

public class DashboardFragment extends Fragment {

    private DashboardViewModel dashboardViewModel;
    public static View viewModal;
    Context context;

    public View onCreateView(@NonNull LayoutInflater inflater,  ViewGroup container, Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);

        context = getActivity();
        SharedPreferences pref = PreferenceManager.getDefaultSharedPreferences(context);
        Integer index = pref.getInt("index",40);

        int products[] = {R.drawable.p1, R.drawable.p2, R.drawable.p3, R.drawable.p4,
                R.drawable.p5, R.drawable.p6, R.drawable.p7, R.drawable.p8, R.drawable.p9};

        GridAdapterHolder gah = new GridAdapterHolder();

        // inflate main layout
        dashboardViewModel = new ViewModelProvider(this).get(DashboardViewModel.class);
        viewModal = inflater.inflate(R.layout.fragment_dashboard, container, false);

        // set app toolbar title
        TextView toolbar_title = (TextView) getActivity().findViewById(R.id.toolbar_title);
        toolbar_title.setText(R.string.title_dashboard);

        // set app toolbar icon
        ImageView index_drop = (ImageView) getActivity().findViewById(R.id.index_drop);
        if(index_drop!=null) {
            index_drop.setImageDrawable(getResources().getDrawable(R.drawable.ic_add));
            index_drop.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                }
            });
        }

        // bind grid view adapter
        GridView orasView = (GridView) viewModal.findViewById(R.id.orasGridView);
        GridAdapter customAdapter = new GridAdapter(context, products);
        orasView.setAdapter(customAdapter);

        // implement setOnItemClickListener event on GridView
        orasView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                // set an Intent to Another Activity

                String oras_title = GridAdapter.products[position];
                String oras_id = String.valueOf(position+1);
                String oras_status = GridAdapter.status[position];

                String url = "https://scirow.kenzap.com/analytics/?id="+oras_id+"&"+"status="+oras_status+"&title="+oras_title;
                Log.i("Dashboard", url);
                CustomTabsIntent.Builder builder = new CustomTabsIntent.Builder();
                CustomTabsIntent customTabsIntent = builder.build();
                customTabsIntent.launchUrl(context, Uri.parse(url));

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