package com.scirow.app.ui.dashboard;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.scirow.app.R;

import org.w3c.dom.Text;

public class GridAdapter extends BaseAdapter {

    Context context;
    int logos[];
    LayoutInflater inflter;
    public static String products[] = {"Dishwasher", "Hydractiva shower", "Optima faucet", "Kitchen optima faucet",
            "Washing machine", "Shower faucet", "Basin electra", "Kitchen faucet 2", "Kitchen faucet 3"};
    public static String status[] = {"ok", "ok", "ok", "battery",
            "ok", "ok", "warning", "ok", "ok"};

    public GridAdapter(Context applicationContext, int[] logos) {
        this.context = applicationContext;
        this.logos = logos;
        inflter = (LayoutInflater.from(applicationContext));
    }
    @Override
    public int getCount() {
        return logos.length;
    }
    @Override
    public Object getItem(int i) {
        return null;
    }
    @Override
    public long getItemId(int i) {
        return 0;
    }
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        view = inflter.inflate(R.layout.adapter_oras_grid_view, null); // inflate the layout
        ImageView img = (ImageView) view.findViewById(R.id.product); // get the reference of ImageView
        TextView desc = (TextView) view.findViewById(R.id.desc);
        ImageView icon = (ImageView) view.findViewById(R.id.icon);

        // set warning for this oras product
        if(status[i].equals("warning")){
            icon.setVisibility(View.VISIBLE);
            icon.setImageDrawable(context.getResources().getDrawable(R.drawable.ic_warning));
        }

        if(status[i].equals("battery")){
            icon.setVisibility(View.VISIBLE);
            icon.setImageDrawable(context.getResources().getDrawable(R.drawable.ic_battery_low));
        }

        img.setImageResource(logos[i]); // set logo images
        desc.setText(products[i]);

        return view;
    }
}
