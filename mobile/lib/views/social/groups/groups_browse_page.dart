import 'package:erasmus_helper/views/social/groups/components/group_carousel.dart';
import 'package:flutter/material.dart';

import 'components/group_card.dart';

class GroupBrowserPage extends StatefulWidget {
  const GroupBrowserPage({Key? key}) : super(key: key);

  @override
  State<GroupBrowserPage> createState() => _GroupBrowserState();
}

class _GroupBrowserState extends State<GroupBrowserPage> {
  @override
  Widget build(BuildContext context) {
    return const GroupCarousel(tagId: "1");
  }
}
