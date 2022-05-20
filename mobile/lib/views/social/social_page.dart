import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:erasmus_helper/views/social/cultural_tab.dart';
import 'package:erasmus_helper/views/social/forums_tab.dart';
import 'package:flutter/material.dart';


// TODO : replace this page with the good content
class SocialPage extends StatelessWidget {
  const SocialPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const DefaultTabController(
        length: 2,
        child: AppTopBar(
          body: TabBarView(
            children: [
              ForumsTab(),
              CulturalTab()
            ],
          ),
          title: "Social",
          bottom: TabBar(
              tabs: [
                Tab(text: "Forums",),
                Tab(text: "Cultural",)
              ]
          ),
        )
    );
  }
}