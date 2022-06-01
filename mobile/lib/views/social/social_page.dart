import 'package:erasmus_helper/views/social/cultural/cultural_tab.dart';
import 'package:erasmus_helper/views/social/groups/forums_tab.dart';
import 'package:flutter/material.dart';

class SocialPage extends StatelessWidget {
  const SocialPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const DefaultTabController(
      length: 2,
      child: TabBarView(
        children: [ForumsTab(), CulturalTab()],
      ),
    );
  }
}
