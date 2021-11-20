package com.scirow.app.ui.home;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.Uri;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.browser.customtabs.CustomTabsIntent;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.ekndev.gaugelibrary.HalfGauge;
import com.ekndev.gaugelibrary.Range;
import com.scirow.app.R;
import com.scirow.app.databinding.FragmentHomeBinding;

public class HomeFragment extends Fragment {

    private HomeViewModel homeViewModel;
    public static View viewModal;
    Context context;

    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);

        context = getActivity();
        SharedPreferences pref = PreferenceManager.getDefaultSharedPreferences(context);
        Integer index = pref.getInt("index",88);

        // inflate main layout
        homeViewModel = new ViewModelProvider(this).get(HomeViewModel.class);
        viewModal = inflater.inflate(R.layout.fragment_home, container, false);

        // bind views
        TextView text_home = (TextView) viewModal.findViewById(R.id.text_home);
        TextView text_home2 = (TextView) viewModal.findViewById(R.id.text_home2);
        ImageView image_view = (ImageView) viewModal.findViewById(R.id.image_view);

        // https://github.com/Gruzer/simple-gauge-android
        com.ekndev.gaugelibrary.ArcGauge half_gauge = (com.ekndev.gaugelibrary.ArcGauge) viewModal.findViewById(R.id.half_gauge);

        // link data with views
        text_home.setText("sustainability index");
        text_home2.setText("better than yesterday \uD83D\uDE80");

        Range range1 = new Range();
        range1.setColor(Color.parseColor("#B71D2C"));
        range1.setFrom(0);
        range1.setTo(33);

        Range range2 = new Range();
        range2.setColor(Color.parseColor("#FFB847"));
        range2.setFrom(33);
        range2.setTo(66);

        Range range3 = new Range();
        range3.setColor(Color.parseColor("#72A105"));
        range3.setFrom(66);
        range3.setTo(100);

        half_gauge.addRange(range1);
        half_gauge.addRange(range2);
        half_gauge.addRange(range3);

        half_gauge.setValue(index);

        // low index
        if(index >= 0 && index < 33){
            image_view.setImageDrawable(getResources().getDrawable(R.drawable.ic_nature_1));
        }

        // medium index
        if(index >= 33 && index < 66){
            image_view.setImageDrawable(getResources().getDrawable(R.drawable.ic_nature_2));
        }

        // high index
        if(index >= 66 && index < 100){
            image_view.setImageDrawable(getResources().getDrawable(R.drawable.ic_nature_3));
        }

        // set app title
        TextView toolbar_title = (TextView) getActivity().findViewById(R.id.toolbar_title);
        if(toolbar_title!=null) toolbar_title.setText(R.string.app_name);

        // set app toolbar icon
        ImageView index_drop = (ImageView) getActivity().findViewById(R.id.index_drop);
        if(index_drop!=null) {

            index_drop.setImageDrawable(getResources().getDrawable(R.drawable.ic_drops_empty));
            index_drop.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    String url = "https://scirow.kenzap.com/leadership/";
                    CustomTabsIntent.Builder builder = new CustomTabsIntent.Builder();
                    CustomTabsIntent customTabsIntent = builder.build();
                    customTabsIntent.launchUrl(context, Uri.parse(url));
                }
            });
        }

        return viewModal;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        // binding = null;
    }
}