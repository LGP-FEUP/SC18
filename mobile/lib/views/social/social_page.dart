import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:erasmus_helper/views/social/cultural/cultural_tab.dart';
import 'package:erasmus_helper/views/social/forums_tab.dart';
import 'package:flutter/material.dart';

class SocialPage extends StatelessWidget {
  const SocialPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
        length: 2,
        child: AppTopBar(
          body: const TabBarView(
            children: [ForumsTab(), CulturalTab()],
          ),
          title: "Social",
          bottom: TabBar(
              indicatorColor: Theme.of(context).primaryColor,
              labelColor: Theme.of(context).primaryColor,
              tabs: const [
                Tab(
                  text: "Forums",
                ),
                Tab(
                  text: "Cultural",
                )
              ]),
        ));
  }
}
