package com.ratga.mymix.models;
import android.os.Parcel;
import android.os.Parcelable;

import java.util.Date;
import java.util.concurrent.ThreadLocalRandom;

public class Session implements Parcelable {
    private Integer  sessionId;
    private Integer  userId;
    private Date creationTime;
    private User user;

    public Integer  getSessionId()
    {
        return this.sessionId;
    }

    public void setSessionId(Integer  sessionId)
    {
        this.sessionId = sessionId;
    }

    public Integer  getUserId()
    {
        return this.userId;
    }

    public void setUserId(Integer  userId)
    {
        this.userId = userId;
    }

    public Date getCreationTime()
    {
        return this.creationTime;
    }

    public void setCreationTime(Date creationTime)
    {
        this.creationTime = creationTime;
    }

    public User getUser()
    {
        return this.user;
    }

    public void setUser(User user)
    {
        this.user = user;
    }

    public Session(Integer  userId, User user)
    {
        this.userId = userId;
        this.sessionId = ThreadLocalRandom.current().nextInt(0, Integer.MAX_VALUE);
        this.user = user;
        this.creationTime = new Date(0);
    }


    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeValue(this.sessionId);
        dest.writeValue(this.userId);
        dest.writeLong(this.creationTime != null ? this.creationTime.getTime() : -1);
        dest.writeParcelable(this.user, flags);
    }

    protected Session(Parcel in) {
        this.sessionId = (Integer) in.readValue(Integer.class.getClassLoader());
        this.userId = (Integer) in.readValue(Integer.class.getClassLoader());
        long tmpCreationTime = in.readLong();
        this.creationTime = tmpCreationTime == -1 ? null : new Date(tmpCreationTime);
        this.user = in.readParcelable(User.class.getClassLoader());
    }

    public static final Parcelable.Creator<Session> CREATOR = new Parcelable.Creator<Session>() {
        @Override
        public Session createFromParcel(Parcel source) {
            return new Session(source);
        }

        @Override
        public Session[] newArray(int size) {
            return new Session[size];
        }
    };
}
