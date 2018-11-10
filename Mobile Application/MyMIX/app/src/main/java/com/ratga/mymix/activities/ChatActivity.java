package com.ratga.mymix.activities;
import android.os.Handler;
import android.os.StrictMode;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;

import com.ratga.mymix.R;
import com.ratga.mymix.daos.Users;
import com.ratga.mymix.models.Message;
import com.ratga.mymix.models.Session;
import com.ratga.mymix.models.User;
import com.ratga.mymix.daos.Messages;
import com.stfalcon.chatkit.messages.MessageInput;
import com.stfalcon.chatkit.messages.MessagesList;
import com.stfalcon.chatkit.messages.MessagesListAdapter;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ChatActivity extends AppCompatActivity {

    private MessagesList messagesList;
    private MessageInput messageInput;

    private Handler handler;
    private Runnable messagesGettter;
    private User user;
    private Session session;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat);
        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();

        StrictMode.setThreadPolicy(policy);
        messagesList = findViewById(R.id.messagesList);
        messageInput = findViewById(R.id.input);
        user = getIntent().getParcelableExtra("user");
        session = getIntent().getParcelableExtra("session");
        final MessagesListAdapter<Message> adapter = new MessagesListAdapter<>(user.getId(), null);
        messagesList.setAdapter(adapter);
        Messages.getMessagesBySessionId(session.getSessionId(), new Callback<List<Message>>() {
            @Override
            public void onResponse(Call<List<Message>> call, Response<List<Message>> response) {
                if (response.body().get(0).getSessionId() == 0) {
                    User bot = Users.getUsersByUserId(0).get(0);
                    Messages.addMessage(new Message(bot, session, "Hi, I am Sam!"));
                    Messages.addMessage(new Message(bot, session, "How can I help you?"));
                }
                startPollingMessage(adapter, session.getSessionId());
            };
            @Override
            public void onFailure(Call<List<Message>> call, Throwable t) {
                System.out.println();
            }
        });

        messageInput.setInputListener(new MessageInput.InputListener() {
            @Override
            public boolean onSubmit(CharSequence input) {
                Messages.addMessage(new Message(user,session, input.toString()));
                return true;
            }
        });
    }

    private void startPollingMessage(final MessagesListAdapter<Message> adapter, final int session) {
        handler = new Handler();
        messagesGettter = new Runnable() {
            @Override
            public void run() {
                final Runnable r = this;
                Messages.getMessagesBySessionId(session, new Callback<List<Message>>() {
                    @Override
                    public void onResponse(Call<List<Message>> call, Response<List<Message>> response) {
                        for (Message m : response.body())
                            adapter.upsert(m);
                        handler.postDelayed(r, 300);
                    }

                    @Override
                    public void onFailure(Call<List<Message>> call, Throwable t) {
                        Log.d("POOL", "Request failed!");
                    }
                });
            }
        };
        handler.post(messagesGettter);
    }
}
