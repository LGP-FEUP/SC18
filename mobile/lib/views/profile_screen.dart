import 'package:flutter/material.dart';

class ProfileScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text("Profile"),
        ),
        body: Container(
          padding: EdgeInsets.all(15.0),
          child: Column(
            children: [
              _buildProfileBanner(),
              SizedBox(
                height: 40.0,
              ),
              Column(
                children: [
                  _buildInfoListTile(Icons.school_rounded, "FEUP"),
                  _buildInfoListTile(Icons.phone, "+49176123919392"),
                  _buildInfoListTile(Icons.whatsapp_rounded, "+49176123919392"),
                  _buildInfoListTile(Icons.facebook_rounded, "/sarahschaab")
                ],
              ),
              SizedBox(
                height: 20.0,
              ),
              _buildChipList([
                "hiking",
                "music",
                "sport",
                "games",
                "party",
                "cooking",
                "surfing",
                "basketball",
                "soccer",
                "karaoke"
              ])
            ],
          ),
        ));
  }

  Row _buildProfileBanner() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        CircleAvatar(
          backgroundImage: AssetImage("assets/avatar.jpg"),
          radius: 60,
        ),
        SizedBox(
          width: 20.0,
        ),
        Flexible(
            fit: FlexFit.loose,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Row(
                  children: [
                    Text(
                      "Sarah Schaab",
                      style: TextStyle(
                          fontWeight: FontWeight.bold, fontSize: 18.0),
                    ),
                    SizedBox(
                      width: 10.0,
                    ),
                    Image.asset(
                      "assets/flags/de.png",
                      height: 15.0,
                    )
                  ],
                ),
                SizedBox(
                  height: 10.0,
                ),
                Text("Discovering new people and new things"),
              ],
            ))
      ],
    );
  }

  Widget _buildChipList(List<String> labels) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Interests",
          style: TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 18.0,
              color: Colors.blueGrey.shade400),
        ),
        SizedBox(
          height: 5.0,
        ),
        Wrap(
          spacing: 6.0,
          runSpacing: 6.0,
          children: labels.map((label) => _buildChip(label)).toList(),
        ),
      ],
    );
  }

  Widget _buildChip(String label) {
    return Chip(
      label: Text(
        label,
        style: TextStyle(color: Colors.white),
      ),
      elevation: 2.0,
      shadowColor: Colors.grey[60],
      backgroundColor: Colors.blueGrey.shade600,
      padding: EdgeInsets.all(8.0),
    );
  }

  Widget _buildInfoListTile(IconData icon, String content) {
    return Column(
      children: [
        ListTile(
          tileColor: Colors.blueGrey.shade100,
          trailing: Icon(icon),
          title: Text(content),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15.0),
          ),
        ),
        SizedBox(
          height: 15.0,
        )
      ],
    );
  }
}
